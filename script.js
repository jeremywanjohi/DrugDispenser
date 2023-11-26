function addDrugDetails() {

    const drugName = document.getElementById('drugName').value;

    const category = document.getElementById('category').value;

    const image = document.getElementById('image').value;







    console.log('Drug Name:', drugName);

    console.log('Category:', category);

    console.log('Image URL:', image);




    // Clear the form after submission

    document.getElementById('drugForm').reset();

  }



    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        // Get the form data
        const drugName = document.getElementById("drugName").value;
        const category = document.getElementById("category").value;
        const image = document.getElementById("image").value;

        // Create a FormData object to send the data to drugdetails.php
        const formData = new FormData();
        formData.append("drugName", drugName);
        formData.append("category", category);
        formData.append("image", image);

        // Send a POST request to drugdetails.php with the form data
        fetch("drugdetails.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                // Handle the response data if needed
                console.log(data);

                // After handling the data, redirect the user to products.php
                window.location.href = "products.php";
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
