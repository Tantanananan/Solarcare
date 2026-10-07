using System.ComponentModel.DataAnnotations;

namespace SolarCare.Web.Models;

public class AuthViewModel
{
    public string? ErrorMessage { get; set; }
    public string? SuccessMessage { get; set; }
    public string ActiveForm { get; set; } = "login"; // login or register
}

public class LoginViewModel
{
    [Required]
    [EmailAddress]
    public string Email { get; set; }

    [Required]
    public string Password { get; set; }
}

public class RegisterViewModel
{
    [Required]
    public string FullName { get; set; }

    [Required]
    [EmailAddress]
    public string Email { get; set; }

    [Required]
    [MinLength(6, ErrorMessage = "The password must be at least 6 characters long.")]
    public string Password { get; set; }

    [Required]
    [Compare("Password", ErrorMessage = "The password and confirmation password do not match.")]
    public string ConfirmPassword { get; set; }
}
