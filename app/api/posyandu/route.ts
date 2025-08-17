import { type NextRequest, NextResponse } from "next/server"
import { dataStorage } from "@/lib/storage"

export async function GET(request: NextRequest) {
  try {
    const searchParams = request.nextUrl.searchParams
    const query = searchParams.get("q")

    let data
    if (query) {
      data = dataStorage.search(query)
    } else {
      data = dataStorage.getAll()
    }

    return NextResponse.json(data)
  } catch (error) {
    return NextResponse.json({ error: "Gagal memuat data" }, { status: 500 })
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json()

    // Basic validation
    if (!body.nama || !body.dusun || !body.kategori) {
      return NextResponse.json({ error: "Data tidak lengkap" }, { status: 400 })
    }

    const newData = dataStorage.create(body)
    return NextResponse.json(newData, { status: 201 })
  } catch (error) {
    return NextResponse.json({ error: "Gagal menyimpan data" }, { status: 500 })
  }
}
