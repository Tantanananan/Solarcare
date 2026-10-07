using System.Diagnostics;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using SolarCare.Web.Models;

namespace SolarCare.Web.Controllers;

public class HomeController : Controller
{
    private readonly UserManager<IdentityUser> _userManager;
    private readonly SignInManager<IdentityUser> _signInManager;

    public HomeController(UserManager<IdentityUser> userManager, SignInManager<IdentityUser> signInManager)
    {
        _userManager = userManager;
        _signInManager = signInManager;
    }

    [HttpGet]
    public IActionResult Index()
    {
        return View(new AuthViewModel());
    }

    [HttpPost]
    public async Task<IActionResult> Login(LoginViewModel model)
    {
        var authModel = new AuthViewModel { ActiveForm = "login" };

        if (!ModelState.IsValid)
        {
            authModel.ErrorMessage = "Please provide both email and password.";
            return View("Index", authModel);
        }

        var result = await _signInManager.PasswordSignInAsync(model.Email, model.Password, isPersistent: false, lockoutOnFailure: false);
        
        if (result.Succeeded)
        {
            return RedirectToAction("Dashboard"); 
        }

        authModel.ErrorMessage = "Invalid email or password.";
        return View("Index", authModel);
    }

    [HttpPost]
    public async Task<IActionResult> Register(RegisterViewModel model)
    {
        var authModel = new AuthViewModel { ActiveForm = "register" };

        if (!ModelState.IsValid)
        {
            authModel.ErrorMessage = string.Join(" ", ModelState.Values.SelectMany(v => v.Errors).Select(e => e.ErrorMessage));
            return View("Index", authModel);
        }

        var user = new IdentityUser { UserName = model.Email, Email = model.Email };
        var result = await _userManager.CreateAsync(user, model.Password);

        if (result.Succeeded)
        {
            authModel.SuccessMessage = "Registration successful! You can now sign in.";
            authModel.ActiveForm = "login";
            return View("Index", authModel);
        }

        authModel.ErrorMessage = string.Join(" ", result.Errors.Select(e => e.Description));
        return View("Index", authModel);
    }

    [Microsoft.AspNetCore.Authorization.Authorize]
    public IActionResult Dashboard()
    {
        return View();
    }

    [Microsoft.AspNetCore.Authorization.Authorize]
    public IActionResult AdminDashboard()
    {
        return View();
    }

    [HttpPost]
    public async Task<IActionResult> Logout()
    {
        await _signInManager.SignOutAsync();
        return RedirectToAction("Index");
    }

    public IActionResult Privacy()
    {
        return View();
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
        return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
}
