using Microsoft.EntityFrameworkCore;
using Todo.Api.Models;

namespace Todo.Api.Data
{
    public class TodoDb : DbContext
    {
        public TodoDb(DbContextOptions<TodoDb> options) : base(options) { }

        public DbSet<Todo.Api.Models.Todo> Todos => Set<Todo.Api.Models.Todo>();
    }
}
