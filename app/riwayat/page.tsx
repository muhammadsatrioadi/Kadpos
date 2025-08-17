"use client"

import { useState, useMemo } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { useToast } from "@/hooks/use-toast"
import { useRouter } from "next/navigation"
import { Plus, Download, FileText } from "lucide-react"
import { DataTable } from "@/components/data-table"
import { SearchBar } from "@/components/search-bar"
import { LoadingSpinner } from "@/components/loading-spinner"
import { usePosyanduData } from "@/hooks/usePosyanduData"
import { exportToCSV } from "@/lib/utils"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"

export default function RiwayatPosyandu() {
  const [searchQuery, setSearchQuery] = useState("")
  const [deleteId, setDeleteId] = useState<string | null>(null)
  const { data, isLoading, error, deleteData } = usePosyanduData()
  const { toast } = useToast()
  const router = useRouter()

  const filteredData = useMemo(() => {
    if (!searchQuery.trim()) return data

    const query = searchQuery.toLowerCase()
    return data.filter(
      (item) =>
        item.nama.toLowerCase().includes(query) ||
        item.kategori.toLowerCase().includes(query) ||
        item.dusun.toLowerCase().includes(query) ||
        item.alamat.toLowerCase().includes(query),
    )
  }, [data, searchQuery])

  const handleDelete = async (id: string) => {
    try {
      await deleteData(id)
      toast({
        title: "Data berhasil dihapus",
        description: "Data telah dihapus dari sistem",
      })
    } catch (error) {
      toast({
        title: "Error",
        description: error instanceof Error ? error.message : "Gagal menghapus data",
        variant: "destructive",
      })
    }
    setDeleteId(null)
  }

  const handleExport = () => {
    if (filteredData.length === 0) {
      toast({
        title: "Tidak ada data",
        description: "Tidak ada data untuk diekspor",
        variant: "destructive",
      })
      return
    }

    exportToCSV(filteredData, "riwayat_posyandu.csv")
    toast({
      title: "Export berhasil",
      description: `${filteredData.length} data berhasil diekspor`,
    })
  }

  if (isLoading) {
    return <LoadingSpinner message="Memuat data posyandu..." />
  }

  if (error) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 p-4 flex items-center justify-center">
        <div className="text-center">
          <div className="text-red-500 mb-4">
            <svg className="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={1}
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <p className="text-red-600 text-lg font-medium">Error: {error}</p>
          <Button className="mt-4" onClick={() => window.location.reload()}>
            Coba Lagi
          </Button>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 p-4">
      <div className="max-w-7xl mx-auto">
        <div className="flex justify-between items-center mb-6">
          <div>
            <h1 className="text-3xl font-bold text-gray-900">Riwayat Data Posyandu</h1>
            <p className="text-gray-600 mt-2">
              Total: {filteredData.length} data
              {searchQuery && ` (dari ${data.length} total data)`}
            </p>
          </div>
          <div className="flex gap-2">
            <Button onClick={() => router.push("/")}>
              <Plus className="w-4 h-4 mr-2" />
              Tambah Data
            </Button>
            <Button variant="outline" onClick={handleExport}>
              <Download className="w-4 h-4 mr-2" />
              Export CSV
            </Button>
          </div>
        </div>

        <Card>
          <CardHeader>
            <CardTitle className="flex items-center gap-2">
              <FileText className="w-5 h-5" />
              Data Kesehatan Masyarakat
            </CardTitle>
            <CardDescription>Pencarian dan pengelolaan data posyandu</CardDescription>
            <div className="flex gap-4 mt-4">
              <SearchBar
                value={searchQuery}
                onChange={setSearchQuery}
                placeholder="Cari berdasarkan nama, kategori, dusun, atau alamat..."
              />
            </div>
          </CardHeader>
          <CardContent>
            <DataTable data={filteredData} onEdit={(id) => router.push(`/edit/${id}`)} onDelete={setDeleteId} />
          </CardContent>
        </Card>

        {/* Delete Confirmation Dialog */}
        <Dialog open={!!deleteId} onOpenChange={() => setDeleteId(null)}>
          <DialogContent>
            <DialogHeader>
              <DialogTitle>Hapus Data</DialogTitle>
              <DialogDescription>
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
              </DialogDescription>
            </DialogHeader>
            <DialogFooter>
              <Button variant="outline" onClick={() => setDeleteId(null)}>
                Batal
              </Button>
              <Button variant="destructive" onClick={() => deleteId && handleDelete(deleteId)}>
                Hapus
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>
      </div>
    </div>
  )
}
