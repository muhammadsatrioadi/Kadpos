import type { PosyanduData } from "@/types/posyandu"

// In-memory storage - replace with database in production
class DataStorage {
  private data: PosyanduData[] = []
  private nextId = 1

  // Initialize with some sample data
  constructor() {
    this.seedData()
  }

  private seedData() {
    const sampleData: Omit<PosyanduData, "id" | "created_at">[] = [
      {
        dusun: "Dusun Mawar",
        nama: "Siti Aminah",
        kategori: "Ibu Hamil",
        jenis_kelamin: "Perempuan",
        tanggal_lahir: "1995-03-15",
        umur: "29",
        alamat: "Jl. Melati No. 123, RT 02/RW 05",
        nomor_ktp: "3201234567890123",
        nomor_bpjs: "0001234567890",
        berat_badan: "65",
        tinggi_badan: "160",
        imt: "25.4",
        lingkar_perut: "85",
        tekanan_darah: "120/80",
        mental_dan_emosional: "Stabil, tidak ada keluhan",
        keterangan: "Kehamilan trimester 2, kondisi sehat",
      },
      {
        dusun: "Dusun Melati",
        nama: "Ahmad Fauzi",
        kategori: "Balita",
        jenis_kelamin: "Laki-laki",
        tanggal_lahir: "2021-08-20",
        umur: "3",
        alamat: "Jl. Anggrek No. 45, RT 01/RW 03",
        nomor_ktp: "",
        nomor_bpjs: "0009876543210",
        berat_badan: "14",
        tinggi_badan: "95",
        imt: "15.5",
        lingkar_perut: "50",
        tekanan_darah: "",
        mental_dan_emosional: "Aktif, perkembangan normal",
        keterangan: "Imunisasi lengkap sesuai jadwal",
      },
    ]

    sampleData.forEach((item) => {
      this.create(item)
    })
  }

  getAll(): PosyanduData[] {
    return [...this.data].sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime())
  }

  getById(id: string): PosyanduData | undefined {
    return this.data.find((item) => item.id === id)
  }

  create(data: Omit<PosyanduData, "id" | "created_at">): PosyanduData {
    const newItem: PosyanduData = {
      id: this.nextId.toString(),
      ...data,
      created_at: new Date().toISOString(),
    }

    this.data.push(newItem)
    this.nextId++

    return newItem
  }

  update(id: string, data: Partial<Omit<PosyanduData, "id" | "created_at">>): PosyanduData | null {
    const index = this.data.findIndex((item) => item.id === id)

    if (index === -1) return null

    this.data[index] = {
      ...this.data[index],
      ...data,
      updated_at: new Date().toISOString(),
    }

    return this.data[index]
  }

  delete(id: string): boolean {
    const index = this.data.findIndex((item) => item.id === id)

    if (index === -1) return false

    this.data.splice(index, 1)
    return true
  }

  search(query: string): PosyanduData[] {
    if (!query.trim()) return this.getAll()

    const searchTerm = query.toLowerCase()
    return this.data.filter(
      (item) =>
        item.nama.toLowerCase().includes(searchTerm) ||
        item.kategori.toLowerCase().includes(searchTerm) ||
        item.dusun.toLowerCase().includes(searchTerm) ||
        item.alamat.toLowerCase().includes(searchTerm),
    )
  }
}

export const dataStorage = new DataStorage()
