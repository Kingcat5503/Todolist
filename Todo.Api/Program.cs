using Microsoft.EntityFrameworkCore;
using Todo.Api.Data;
using Todo.Api.Models;
using Todo.Api.Endpoints;

var builder = WebApplication.CreateBuilder(args);

// Configure EF Core to use SQLite
builder.Services.AddDbContext<TodoDb>(options =>
    options.UseSqlite("Data Source=todos.db"));

var app = builder.Build();


// ✅ Global Error Handling Middleware
app.Use(async (context, next) =>
{
    try
    {
        await next(); // Continue to next middleware
    }
    catch (Exception ex)
    {
        Console.WriteLine($"[Error] {ex.Message}"); // Log to console

        context.Response.StatusCode = 500; // Internal Server Error
        await context.Response.WriteAsJsonAsync(new
        {
            Error = "An unexpected error occurred.",
            Details = ex.Message // (For debugging, remove in production)
        });
    }
});
app.MapTodoEndpoints();
app.Run();
