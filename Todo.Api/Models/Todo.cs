using System.ComponentModel.DataAnnotations;

namespace Todo.Api.Models
{
    public class Todo
    {
        [Key]public int Id { get; set; }
        [Required][MinLength(3)]public string Task { get; set; } = string.Empty;
        public bool IsComplete { get; set; }
    }
}
