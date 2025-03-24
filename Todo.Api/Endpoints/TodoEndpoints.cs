using Microsoft.EntityFrameworkCore;
using Todo.Api.Data;
using Todo.Api.Models;
using System.ComponentModel.DataAnnotations;

namespace Todo.Api.Endpoints
{
    public static class TodoEndpoints
    {
        public static void MapTodoEndpoints(this WebApplication app)
        {
            // ✅ GET: Retrieve all tasks
            app.MapGet("/todos", async (TodoDb db) =>
            {
                return await db.Todos.ToListAsync();
            });

            // ✅ GET: Retrieve a task by ID
            app.MapGet("/todos/{id}", async (int id, TodoDb db) =>
            {
                var todo = await db.Todos.FindAsync(id);
                return todo is not null ? Results.Ok(todo) : Results.NotFound(new { Error = $"Task with ID {id} not found." });
            });

            // ✅ POST: Validate input & handle errors
            app.MapPost("/todos", async (Todo.Api.Models.Todo newTodo, TodoDb db) =>
            {
                var validationResults = new List<ValidationResult>();
                var context = new ValidationContext(newTodo);

                if (!Validator.TryValidateObject(newTodo, context, validationResults, true))
                    return Results.BadRequest(new { Errors = validationResults.Select(v => v.ErrorMessage) });

                db.Todos.Add(newTodo);
                await db.SaveChangesAsync();
                return Results.Created($"/todos/{newTodo.Id}", newTodo);
            });

            // ✅ POST: Validate input & handle errors
            app.MapPost("/todos/{id}", async (int id, Todo.Api.Models.Todo newTodo, TodoDb db) =>
            {
                var todo = await db.Todos.FindAsync(id);
                if (todo != null)
                    return Results.NotFound(new { Error = $"Task with ID {id} is existing." });
                
                //Assign Id
                newTodo.Id = id;

                var validationResults = new List<ValidationResult>();
                var context = new ValidationContext(newTodo);

                if (!Validator.TryValidateObject(newTodo, context, validationResults, true))
                    return Results.BadRequest(new { Errors = validationResults.Select(v => v.ErrorMessage) });

                db.Todos.Add(newTodo);
                await db.SaveChangesAsync();
                return Results.Created($"/todos/{newTodo.Id}", newTodo);
            });

            // ✅ PUT: Update a task with error handling
            app.MapPut("/todos/{id}", async (int id, Todo.Api.Models.Todo updatedTodo, TodoDb db) =>
            {
                var todo = await db.Todos.FindAsync(id);
                if (todo is null)
                    return Results.NotFound(new { Error = $"Task with ID {id} not found." });

                var validationResults = new List<ValidationResult>();
                var context = new ValidationContext(updatedTodo);

                if (!Validator.TryValidateObject(updatedTodo, context, validationResults, true))
                    return Results.BadRequest(new { Errors = validationResults.Select(v => v.ErrorMessage) });

                todo.Task = updatedTodo.Task;
                todo.IsComplete = updatedTodo.IsComplete;

                await db.SaveChangesAsync();
                return Results.Ok(todo);
            });

            // ✅ DELETE: Handle errors when deleting a task
            app.MapDelete("/todos/{id}", async (int id, TodoDb db) =>
            {
                var todo = await db.Todos.FindAsync(id);
                if (todo is null)
                    return Results.NotFound(new { Error = $"Task with ID {id} not found." });

                db.Todos.Remove(todo);
                await db.SaveChangesAsync();
                return Results.Ok(new { Message = $"Task with ID {id} deleted." });
            });
        }
    }
}
