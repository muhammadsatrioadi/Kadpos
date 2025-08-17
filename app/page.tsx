"use client"

import type React from "react"
import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { useToast } from "@/hooks/use-toast"
import { useRouter } from "next/navigation"
import { Plus, FileText } from "lucide-react"
import { FormFieldComponent } from "@/components/form-field"
import { FORM_FIELDS } from "@/lib/constants"
import { calculateIMT, validateForm } from "@/lib/utils"
import { usePosyanduData } from "@/hooks/usePosyanduData"

export default function FormPosyandu() {
  const [formData, setFormData] = useState<Record<string, string>>({})
  const [errors, setErrors] = useState<Record<string, string>>({})
  const [isSubmitting, setIsSubmitting] = useState(false)
  const { toast } = useToast()
  const router = useRouter()
  const { createData } = usePosyanduData()

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
      await createData(formData)

      toast({
        title: "Data berhasil disimpan!",
        description: "Data posyandu telah ditambahkan ke sistem.",
      })

      setFormData({})
      router.push("/riwayat")
    } catch (error) {
      toast({
        title: "Error",
        description: error instanceof Error ? error.message : "Gagal menyimpan data",
        variant: "destructive",
      })
    } finally {
      setIsSubmitting(false)
    }
  }

  const handleReset = () => {
    setFormData({})
    setErrors({})
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 p-4">
      <div className="max-w-4xl mx-auto">
        <div className="flex justify-between items-center mb-6">
          <div>
            <h1 className="text-3xl font-bold text-gray-900">Sistem Posyandu</h1>
            <p className="text-gray-600 mt-2">Form Pencatatan Data Kesehatan Masyarakat</p>
          </div>
          <div className="flex gap-2">
            <Button variant="outline" onClick={() => router.push("/riwayat")}>
              <FileText className="w-4 h-4 mr-2" />
              Lihat Riwayat
            </Button>
          </div>
        </div>

        <Card>
          <CardHeader>
            <CardTitle className="flex items-center gap-2">
              <Plus className="w-5 h-5" />
              Form Input Data Posyandu
            </CardTitle>
            <CardDescription>
              Lengkapi semua informasi kesehatan dengan teliti. Kolom bertanda <span className="text-red-500">*</span>{" "}
              wajib diisi.
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
                  {isSubmitting ? "Menyimpan..." : "Simpan Data"}
                </Button>
                <Button type="button" variant="outline" onClick={handleReset} className="flex-1 bg-transparent">
                  Reset Form
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
