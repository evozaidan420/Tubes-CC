document.addEventListener("DOMContentLoaded", () => {
  const inventoryForm = document.getElementById("inventoryForm");
  const inventoryTableBody = document.getElementById("inventoryTableBody");
  let inventoryData = [];
  let itemId = 1;

  // Handle form submission
  inventoryForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const itemName = document.getElementById("itemName").value;
    const itemQuantity = document.getElementById("itemQuantity").value;
    const itemCategory = document.getElementById("itemCategory").value;

    inventoryData.push({
      id: itemId++,
      name: itemName,
      quantity: itemQuantity,
      category: itemCategory,
    });

    renderTable();
    inventoryForm.reset();
  });

  // Render inventory table
  function renderTable() {
    inventoryTableBody.innerHTML = "";
    inventoryData.forEach((item, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${item.name}</td>
        <td>${item.quantity}</td>
        <td>${item.category}</td>
        <td><button class="delete-btn" data-id="${item.id}">Delete</button></td>
      `;
      inventoryTableBody.appendChild(row);
    });

    // Add event listeners to delete buttons
    const deleteButtons = document.querySelectorAll(".delete-btn");
    deleteButtons.forEach((button) =>
      button.addEventListener("click", (e) => {
        const id = e.target.getAttribute("data-id");
        inventoryData = inventoryData.filter((item) => item.id != id);
        renderTable();
      })
   );
 }
 function deleteItem(id) {
  if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
      window.location.href = `hapus_barang.php?id=${id}`;
  }
}
});