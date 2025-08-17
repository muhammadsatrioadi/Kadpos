import type { FormField } from "@/types/posyandu"

export const FORM_FIELDS: FormField[] = [
  { key: "dusun", label: "Dusun", type: "text", required: true },
  { key: "nama", label: "Nama Lengkap", type: "text", required: true },
  {
    key: "kategori",
    label: "Kategori",
    type: "select",
    options: ["Balita", "Ibu Hamil", "Ibu Menyusui", "Lansia"],
    required: true,
  },
  {
    key: "jenis_kelamin",
    label: "Jenis Kelamin",
    type: "select",
    options: ["Laki-laki", "Perempuan"],
    required: true,
  },
  { key: "tanggal_lahir", label: "Tanggal Lahir", type: "date", required: true },
  { key: "umur", label: "Umur (tahun)", type: "number", required: true },
  { key: "alamat", label: "Alamat Lengkap", type: "textarea", required: true },
  { key: "nomor_ktp", label: "Nomor KTP", type: "text" },
  { key: "nomor_bpjs", label: "Nomor BPJS", type: "text" },
  { key: "berat_badan", label: "Berat Badan (kg)", type: "number", required: true },
  { key: "tinggi_badan", label: "Tinggi Badan (cm)", type: "number", required: true },
  { key: "imt", label: "IMT (otomatis)", type: "number" },
  { key: "lingkar_perut", label: "Lingkar Perut (cm)", type: "number" },
  { key: "tekanan_darah", label: "Tekanan Darah (mmHg)", type: "text" },
  { key: "mental_dan_emosional", label: "Kondisi Mental & Emosional", type: "textarea" },
  { key: "keterangan", label: "Keterangan Tambahan", type: "textarea" },
]

export const CATEGORY_COLORS = {
  Balita: "bg-blue-100 text-blue-800",
  "Ibu Hamil": "bg-pink-100 text-pink-800",
  "Ibu Menyusui": "bg-purple-100 text-purple-800",
  Lansia: "bg-orange-100 text-orange-800",
} as const
