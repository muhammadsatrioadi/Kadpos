"use client"

import type React from "react"
import { useState, useEffect } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { useToast } from "@/hooks/use-toast"
import { useRouter } from "next/navigation"
import { Edit, ArrowLeft } from "lucide-react"
import { FormFieldComponent } from "@/components/form-field"
import { LoadingSpinner } from "@/components/loading-spinner"
import { FORM_FIELDS } from "@/lib/constants"
import { calculateIMT, validateForm } from "@/lib/utils"
import { usePosyanduItem, usePosyanduData } from "@/hooks/usePosyanduData"

export default function EditPosyandu({ params }: { params: { id: string } }) {
  const [formData, setFormData] = useState<Record<string, string>>({})
  const [errors, setErrors] = useState<Record<string, string>>({})
  const [isSubmitting, setIsSubmitting] = useState(false)
  const { item, isLoading, error } = usePosyanduItem(params.id)
  const { updateData } = usePosyanduData()
  const { toast } = useToast()
  const router = useRouter()

  useEffect(() => {
    if (item) {
      // Convert item to form data format
      const data: Record<string, string> = {}
      FORM_FIELDS.forEach((field) => {
        data[field.key] = item[field.key] || ""
      })
      setFormData(data)
    }
  }, [item])

  const handleInputChange = (key: string, value: string) => {
    setFormData((prev) => ({ ...prev, [key]: value }))

    // Clear error when user starts typing
    if (errors[key]) {
      setErrors((prev) => ({ ...prev, [key]: "" }))
    }

    // Auto calculate IMT when weight and height are entered
    if (key === "berat_badan" || key === "tinggi_badan") {
      const weight = Number.parseFloat(key === "berat_badan" ? value : formData.berat_badan || "0")
      const height = Number.parseFloat(key === "tinggi_badan" ? value : formData.tinggi_badan || "0")

      if (weight > 0 && height > 0) {
        const imt = calculateIMT(weight, height)
        setFormData((prev) => ({ ...prev, imt }))
      }
    }
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()

    // Validate form
    const validationErrors = validateForm(formData)
    if (validationErrors.length > 0) {
      toast({
        title: "Form tidak valid",
        description: validationErrors.join(", "),
        variant: "destructive",
      })
      return
    }

    setIsSubmitting(true)

    try {
      await updateData(params.id, formData)

      toast({
        title: "Data berhasil diperbarui!",
        description: "Perubahan telah disimpan ke sistem.",
      })

      router.push("/riwayat")
    } catch (error) {
      toast({
        title: "Error",
        description: error instanceof Error ? error.message : "Gagal memperbarui data",
        variant: "destructive",
      })
    } finally {
      setIsSubmitting(false)
    }
  }

  if (isLoading) {
    return <LoadingSpinner message="Memuat data untuk diedit..." />
  }

  if (error || !item) {
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
          <p className="text-red-600 text-lg font-medium">{error || "Data tidak ditemukan"}</p>
          <Button className="mt-4" onClick={() => router.push("/riwayat")}>
            Kembali ke Riwayat
          </Button>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 p-4">
      <div className="max-w-4xl mx-auto">
        <div className="flex items-center gap-4 mb-6">
          <Button variant="outline" onClick={() => router.push("/riwayat")}>
            <ArrowLeft className="w-4 h-4 mr-2" />
            Kembali
          </Button>
          <div>
            <h1 className="text-3xl font-bold text-gray-900">Edit Data Posyandu</h1>
            <p className="text-gray-600 mt-2">Perbarui informasi kesehatan</p>
          </div>
        </div>

        <Card>
          <CardHeader>
            <CardTitle className="flex items-center gap-2">
              <Edit className="w-5 h-5" />
              Edit Data: {item.nama}
            </CardTitle>
            <CardDescription>
              Perbarui informasi kesehatan dengan teliti. Kolom bertanda <span className="text-red-500">*</span> wajib
              diisi.
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {FORM_FIELDS.map((field) => (
                  <FormFieldComponent
                    key={field.key}
                    field={field}
                    value={formData[field.key] || ""}
                    onChange={(value) => handleInputChange(field.key, value)}
                    error={errors[field.key]}
                  />
                ))}
              </div>

              <div className="flex gap-4 pt-6">
                <Button type="submit" disabled={isSubmitting} className="flex-1">
                  {isSubmitting ? "Menyimpan..." : "Perbarui Data"}
                </Button>
                <Button type="button" variant="outline" onClick={() => router.push("/riwayat")} className="flex-1">
                  Batal
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
