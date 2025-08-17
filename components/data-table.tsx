"use client"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Edit, Trash2, Eye } from "lucide-react"
import type { PosyanduData } from "@/types/posyandu"
import { CATEGORY_COLORS } from "@/lib/constants"
import { formatDate } from "@/lib/utils"

interface DataTableProps {
  data: PosyanduData[]
  onEdit: (id: string) => void
  onDelete: (id: string) => void
  onView?: (id: string) => void
}

export function DataTable({ data, onEdit, onDelete, onView }: DataTableProps) {
  if (data.length === 0) {
    return (
      <div className="text-center py-12">
        <div className="text-gray-400 mb-4">
          <svg className="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth={1}
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <p className="text-gray-500 text-lg">Belum ada data posyandu</p>
        <p className="text-gray-400 text-sm mt-1">Tambahkan data pertama untuk memulai</p>
      </div>
    )
  }

  return (
    <div className="overflow-x-auto">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Nama</TableHead>
            <TableHead>Kategori</TableHead>
            <TableHead>Dusun</TableHead>
            <TableHead>Jenis Kelamin</TableHead>
            <TableHead>Umur</TableHead>
            <TableHead>BB/TB</TableHead>
            <TableHead>IMT</TableHead>
            <TableHead>Tekanan Darah</TableHead>
            <TableHead>Tanggal Input</TableHead>
            <TableHead className="text-center">Aksi</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {data.map((item) => (
            <TableRow key={item.id} className="hover:bg-gray-50">
              <TableCell className="font-medium">{item.nama}</TableCell>
              <TableCell>
                <Badge className={CATEGORY_COLORS[item.kategori]}>{item.kategori}</Badge>
              </TableCell>
              <TableCell>{item.dusun}</TableCell>
              <TableCell>{item.jenis_kelamin}</TableCell>
              <TableCell>{item.umur} tahun</TableCell>
              <TableCell>
                {item.berat_badan}kg / {item.tinggi_badan}cm
              </TableCell>
              <TableCell>
                <span
                  className={`font-medium ${
                    Number(item.imt) < 18.5
                      ? "text-blue-600"
                      : Number(item.imt) > 25
                        ? "text-red-600"
                        : "text-green-600"
                  }`}
                >
                  {item.imt}
                </span>
              </TableCell>
              <TableCell>{item.tekanan_darah || "-"}</TableCell>
              <TableCell className="text-sm text-gray-500">{formatDate(item.created_at)}</TableCell>
              <TableCell>
                <div className="flex gap-1 justify-center">
                  {onView && (
                    <Button size="sm" variant="outline" onClick={() => onView(item.id)}>
                      <Eye className="w-3 h-3" />
                    </Button>
                  )}
                  <Button size="sm" variant="outline" onClick={() => onEdit(item.id)}>
                    <Edit className="w-3 h-3" />
                  </Button>
                  <Button
                    size="sm"
                    variant="outline"
                    className="text-red-600 hover:text-red-700 hover:bg-red-50 bg-transparent"
                    onClick={() => onDelete(item.id)}
                  >
                    <Trash2 className="w-3 h-3" />
                  </Button>
                </div>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </div>
  )
}
