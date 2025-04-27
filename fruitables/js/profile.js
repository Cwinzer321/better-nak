document.addEventListener("DOMContentLoaded", function () {
	const profilePictureInput = document.getElementById("profile_picture");
	const profilePictureImg = document.querySelector(".profile-picture");

	if (profilePictureInput) {
		profilePictureInput.addEventListener("change", async function () {
			try {
				const file = this.files[0];
				if (!file) {
					showAlert("warning", "No file selected");
					return;
				}

				// Validate file type and size
				const validTypes = ["image/jpeg", "image/png", "image/gif"];
				const maxSize = 5 * 1024 * 1024; // 5MB

				if (!validTypes.includes(file.type)) {
					showAlert(
						"danger",
						"Please upload a valid image file (JPEG, PNG, or GIF)"
					);
					this.value = ""; // Clear the input
					return;
				}

				if (file.size > maxSize) {
					showAlert("danger", "File size must be less than 5MB");
					this.value = ""; // Clear the input
					return;
				}

				// Show loading indicator
				showAlert("info", "Uploading profile picture...");

				const formData = new FormData();
				formData.append("profile_picture", file);

				// Add CSRF token
				const csrfToken = document.querySelector('input[name="csrf_token"]');
				if (!csrfToken) {
					throw new Error("CSRF token not found");
				}
				formData.append(csrfToken.name, csrfToken.value);

				const response = await fetch("/PK/auth/update_profile_picture", {
					method: "POST",
					body: formData,
					credentials: "same-origin",
					headers: {
						Accept: "application/json",
					},
				});

				let data;
				try {
					data = await response.json();
				} catch (error) {
					throw new Error("Invalid server response format");
				}

				if (!response.ok) {
					const errorMessage =
						data?.message || `Server error: ${response.status}`;
					throw new Error(errorMessage);
				}

				if (!data || typeof data !== "object") {
					throw new Error("Invalid response data");
				}

				if (data.success) {
					// Update profile picture preview
					if (!data.image_url) {
						throw new Error("Image URL not received from server");
					}
					profilePictureImg.src = data.image_url;
					showAlert("success", "Profile picture updated successfully");
					// Clear the file input for next upload
					this.value = "";
				} else {
					throw new Error(data.message || "Failed to update profile picture");
				}
			} catch (error) {
				console.error("Error:", error);
				showAlert(
					"danger",
					error.message ||
						"Failed to update profile picture. Please try again later."
				);
				this.value = ""; // Clear the input on error
			}
		});
	}

	// Handle form validation
	const profileForm = document.querySelector("form.needs-validation");
	if (profileForm) {
		profileForm.addEventListener("submit", function (event) {
			if (!this.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}
			this.classList.add("was-validated");
		});
	}

	// Function to show alert messages
	function showAlert(type, message) {
		const alertDiv = document.createElement("div");
		alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
		alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

		const container = document.querySelector(".container");
		container.insertBefore(alertDiv, container.firstChild);

		// Auto dismiss after 5 seconds
		setTimeout(() => {
			alertDiv.remove();
		}, 5000);
	}

	// Handle account deletion
	window.confirmDeleteAccount = function () {
		if (
			confirm(
				"Are you sure you want to delete your account? This action cannot be undone."
			)
		) {
			window.location.href = "/PK/auth/delete_account";
		}
	};
});
