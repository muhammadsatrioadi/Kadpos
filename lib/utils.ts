import { type ClassValue, clsx } from "clsx"
import { twMerge } from "tailwind-merge"

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export function calculateIMT(weight: number, height: number): string {
  if (weight <= 0 || height <= 0) return ""
  const heightInMeters = height / 100
  const imt = weight / (heightInMeters * heightInMeters)
  return imt.toFixed(1)
}

export function formatDate(dateString: string): string {
  if (!dateString) return ""
  return new Date(dateString).toLocaleDateString("id-ID")
}

export function validateForm(data: Record<string, string>): string[] {
  const errors: string[] = []

  if (!data.nama?.trim()) errors.push("Nama harus diisi")
  if (!data.dusun?.trim()) errors.push("Dusun harus diisi")
  if (!data.kategori) errors.push("Kategori harus dipilih")
  if (!data.jenis_kelamin) errors.push("Jenis kelamin harus dipilih")
  if (!data.tanggal_lahir) errors.push("Tanggal lahir harus diisi")
  if (!data.umur || Number(data.umur) <= 0) errors.push("Umur harus diisi dengan benar")
  if (!data.alamat?.trim()) errors.push("Alamat harus diisi")
  if (!data.berat_badan || Number(data.berat_badan) <= 0) errors.push("Berat badan harus diisi dengan benar")
  if (!data.tinggi_badan || Number(data.tinggi_badan) <= 0) errors.push("Tinggi badan harus diisi dengan benar")

  return errors
}

export function exportToCSV(data: any[], filename = "data.csv") {
  if (data.length === 0) return

  const headers = Object.keys(data[0]).filter((key) => key !== "id")
  const csvContent = [
    headers.map((header) => header.replace(/_/g, " ").toUpperCase()).join(","),
    ...data.map((row) => headers.map((header) => `"${row[header] || ""}"`).join(",")),
  ].join("\n")

  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" })
  const link = document.createElement("a")
  const url = URL.createObjectURL(blob)

  link.setAttribute("href", url)
  link.setAttribute("download", filename)
  link.style.visibility = "hidden"

  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}
