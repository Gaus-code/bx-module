const forms = document.querySelector(".modal"),
	pwShowHide = document.querySelectorAll(".modalField__eye"),
	buttons = document.querySelectorAll(".modalCard__availability_btn"),
	links = document.querySelectorAll(".modal__item");

pwShowHide.forEach(eyeIcon => {
	eyeIcon.addEventListener("click", () => {
		let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
		pwFields.forEach(password => {
			if (password.type === "password")
			{
				password.type = "text";
				return;
			}
			password.type = "password";
		})
	})
});

const handleClick = (e) => {
	e.preventDefault();
	forms.classList.toggle("show__signUp");
};

buttons.forEach((link) => link.addEventListener("click", handleClick));
links.forEach((link) => link.addEventListener("click", handleClick));