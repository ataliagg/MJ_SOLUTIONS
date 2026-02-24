
document.addEventListener("DOMContentLoaded", function() {

  const total = 2350;
  const amountInput = document.getElementById("amountPaid");
  const balanceSpan = document.getElementById("balance");
  const status = document.getElementById("status");

  function updateStatus() {
    const paid = Number(amountInput.value);
    const balance = total - paid;
    balanceSpan.textContent = "$" + balance.toFixed(2);

    status.className = "status";

    if (paid <= 0) {
      status.textContent = "UNPAID";
      status.classList.add("unpaid");
    } else if (paid < total) {
      status.textContent = "PARTIAL";
      status.classList.add("partial");
    } else {
      status.textContent = "PAID";
      status.classList.add("paid");
    }
  }

  const today = new Date();
  document.getElementById("issueDate").textContent = today.toLocaleDateString();
  document.getElementById("dueDate").textContent = new Date(today.setMonth(today.getMonth()+1)).toLocaleDateString();

  amountInput.addEventListener("input", updateStatus);

});
