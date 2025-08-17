export interface PosyanduData {
  id: string
  dusun: string
  nama: string
  kategori: "Balita" | "Ibu Hamil" | "Ibu Menyusui" | "Lansia"
  jenis_kelamin: "Laki-laki" | "Perempuan"
  tanggal_lahir: string
  umur: string
  alamat: string
  nomor_ktp: string
  nomor_bpjs: string
  berat_badan: string
  tinggi_badan: string
  imt: string
  lingkar_perut: string
  tekanan_darah: string
  mental_dan_emosional: string
  keterangan: string
  created_at: string
  updated_at?: string
}

export interface FormField {
  key: keyof Omit<PosyanduData, "id" | "created_at" | "updated_at">
  label: string
  type: "text" | "number" | "date" | "select" | "textarea"
  options?: string[]
  required?: boolean
}

export interface ApiResponse<T> {
  data?: T
  error?: string
  message?: string
}
