// Sistem Posyandu - Custom JavaScript

// Import Bootstrap
const bootstrap = window.bootstrap

// Auto-hide alerts after 5 seconds
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    const alerts = document.querySelectorAll(".alert:not(.alert-permanent)")
    alerts.forEach((alert) => {
      if (bootstrap.Alert.getOrCreateInstance) {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert)
        bsAlert.close()
      }
    })
  }, 5000)
})

// Confirm logout
function confirmLogout() {
  return confirm("Apakah Anda yakin ingin keluar dari sistem?")
}

// Confirm delete
function confirmDelete(nama) {
  return confirm(`Apakah Anda yakin ingin menghapus data ${nama}?\n\nTindakan ini tidak dapat dibatalkan.`)
}

// Auto calculate IMT
function calculateIMT() {
  const beratBadan = Number.parseFloat(document.getElementById("berat_badan")?.value || 0)
  const tinggiBadan = Number.parseFloat(document.getElementById("tinggi_badan")?.value || 0)

  if (beratBadan > 0 && tinggiBadan > 0) {
    // Calculate IMT locally first for immediate feedback
    const tinggiMeter = tinggiBadan / 100
    const imt = (beratBadan / (tinggiMeter * tinggiMeter)).toFixed(1)

    const imtField = document.getElementById("imt")
    if (imtField) {
      imtField.value = imt
    }

    // Also send to server for consistency
    fetch("/api/calculate-imt", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        berat_badan: beratBadan,
        tinggi_badan: tinggiBadan,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (imtField) {
          imtField.value = data.imt
        }
      })
      .catch((error) => {
        console.log("Error calculating IMT:", error)
      })
  }
}

// Initialize IMT calculation listeners
document.addEventListener("DOMContentLoaded", () => {
  const beratBadanField = document.getElementById("berat_badan")
  const tinggiBadanField = document.getElementById("tinggi_badan")

  if (beratBadanField) beratBadanField.addEventListener("input", calculateIMT)
  if (tinggiBadanField) tinggiBadanField.addEventListener("input", calculateIMT)
})

// Form validation
function validateForm(formId) {
  const form = document.getElementById(formId)
  if (!form) return true

  const requiredFields = form.querySelectorAll("[required]")
  let isValid = true

  requiredFields.forEach((field) => {
    if (!field.value.trim()) {
      field.classList.add("is-invalid")
      isValid = false
    } else {
      field.classList.remove("is-invalid")
    }
  })

  if (!isValid) {
    alert("Mohon lengkapi semua field yang wajib diisi (bertanda *)")
  }

  return isValid
}

// Search functionality
function handleSearch(event) {
  if (event.key === "Enter") {
    event.preventDefault()
    const form = event.target.closest("form")
    if (form) {
      form.submit()
    }
  }
}

// Initialize search listeners
document.addEventListener("DOMContentLoaded", () => {
  const searchInputs = document.querySelectorAll('input[name="search"]')
  searchInputs.forEach((input) => {
    input.addEventListener("keypress", handleSearch)
  })
})
