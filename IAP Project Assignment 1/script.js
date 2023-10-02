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
  