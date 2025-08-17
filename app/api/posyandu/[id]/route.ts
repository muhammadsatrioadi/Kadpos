import { type NextRequest, NextResponse } from "next/server"
import { dataStorage } from "@/lib/storage"

export async function GET(request: NextRequest, { params }: { params: { id: string } }) {
  try {
    const item = dataStorage.getById(params.id)

    if (!item) {
      return NextResponse.json({ error: "Data tidak ditemukan" }, { status: 404 })
    }

    return NextResponse.json(item)
  } catch (error) {
    return NextResponse.json({ error: "Gagal memuat data" }, { status: 500 })
  }
}

export async function PUT(request: NextRequest, { params }: { params: { id: string } }) {
  try {
    const body = await request.json()

    const updatedData = dataStorage.update(params.id, body)

    if (!updatedData) {
      return NextResponse.json({ error: "Data tidak ditemukan" }, { status: 404 })
    }

    return NextResponse.json(updatedData)
  } catch (error) {
    return NextResponse.json({ error: "Gagal memperbarui data" }, { status: 500 })
  }
}

export async function DELETE(request: NextRequest, { params }: { params: { id: string } }) {
  try {
    const success = dataStorage.delete(params.id)

    if (!success) {
      return NextResponse.json({ error: "Data tidak ditemukan" }, { status: 404 })
    }

    return NextResponse.json({ message: "Data berhasil dihapus" })
  } catch (error) {
    return NextResponse.json({ error: "Gagal menghapus data" }, { status: 500 })
  }
}
