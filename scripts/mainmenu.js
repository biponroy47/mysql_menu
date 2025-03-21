let sortBy = 'dishname'
let sortOrder = 'ASC'

// function to sort data by price or dishname
function toggleSort() {
  sortBy = sortBy === 'dishname' ? 'price' : 'dishname'
  document.getElementById('sortButton').textContent = `Sort by ${
    sortBy === 'dishname' ? 'Price' : 'Dish Name'
  }`
  fetchTable()
}

// function to order ascending or descending based on selected attribute
function toggleOrder() {
  sortOrder = sortOrder === 'ASC' ? 'DESC' : 'ASC'
  document.getElementById(
    'orderButton'
  ).textContent = `Sort Order: ${sortOrder}`
  fetchTable()
}

// retrieves all current records from menuitems
function fetchTable() {
  fetch(`src/showmenuitems.php?sort=${sortBy}&order=${sortOrder}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById('menuTableBody').innerHTML = data
    })
    .catch((error) => {
      console.error('Error:', error)
    })
}

// popup to confirm deleting menu item, displays error if not possible
window.deleteMenuItem = function (menuitemid) {
  if (confirm('Are you sure you want to delete this menu item?')) {
    fetch('src/deletemenuitem.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `menuitemid=${encodeURIComponent(menuitemid)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        const trimmedData = data.trim()
        if (trimmedData === 'SUCCESS') {
          alert('Item successfully deleted.')
          window.location.reload()
        } else {
          alert('This item cannot be deleted, it is used in an order.')
        }
      })
      .catch((error) => {
        alert('An error occurred while deleting the menu item.')
      })
  }
}

// popup to change menu item price, displays error if not possible
function editPrice(menuitemid) {
  const newPrice = prompt('Enter the new price:')
  if (newPrice !== null && newPrice !== '') {
    if (!/^\d+(\.\d{1,2})?$/.test(newPrice)) {
      alert(
        'Invalid price. Please enter a valid number with up to 2 decimal places.'
      )
      return
    }
    fetch('src/updatemenuitem.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `menuitemid=${encodeURIComponent(
        menuitemid
      )}&field=price&value=${encodeURIComponent(newPrice)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === 'SUCCESS') {
          alert('Price successfully updated.')
          window.location.reload()
        } else {
          alert('An error occurred while updating the price.')
        }
      })
      .catch(() => {
        alert('An error occurred while updating the price.')
      })
  }
}

// popup to change menu item calories, displays error if not possible
function editCalories(menuitemid) {
  const newCalories = prompt('Enter the new calorie count:')
  if (newCalories !== null && newCalories !== '') {
    if (!/^\d+$/.test(newCalories)) {
      alert('Invalid calorie count. Please enter a valid integer.')
      return
    }
    fetch('src/updatemenuitem.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `menuitemid=${encodeURIComponent(
        menuitemid
      )}&field=caloriecount&value=${encodeURIComponent(newCalories)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === 'SUCCESS') {
          alert('Calories successfully updated.')
          window.location.reload()
        } else {
          alert('An error occurred while updating the calories.')
        }
      })
      .catch(() => {
        alert('An error occurred while updating the calories.')
      })
  }
}

fetchTable()
