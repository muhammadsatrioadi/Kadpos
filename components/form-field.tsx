"use client"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Textarea } from "@/components/ui/textarea"
import type { FormField } from "@/types/posyandu"

interface FormFieldProps {
  field: FormField
  value: string
  onChange: (value: string) => void
  error?: string
}

export function FormFieldComponent({ field, value, onChange, error }: FormFieldProps) {
  const renderInput = () => {
    switch (field.type) {
      case "select":
        return (
          <Select value={value} onValueChange={onChange}>
            <SelectTrigger className={error ? "border-red-500" : ""}>
              <SelectValue placeholder={`Pilih ${field.label.toLowerCase()}`} />
            </SelectTrigger>
            <SelectContent>
              {field.options?.map((option) => (
                <SelectItem key={option} value={option}>
                  {option}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        )

      case "textarea":
        return (
          <Textarea
            value={value}
            onChange={(e) => onChange(e.target.value)}
            placeholder={`Masukkan ${field.label.toLowerCase()}`}
            rows={3}
            className={error ? "border-red-500" : ""}
          />
        )

      default:
        return (
          <Input
            type={field.type}
            value={value}
            onChange={(e) => onChange(e.target.value)}
            placeholder={`Masukkan ${field.label.toLowerCase()}`}
            className={error ? "border-red-500" : ""}
            disabled={field.key === "imt"}
          />
        )
    }
  }

  return (
    <div className={field.type === "textarea" ? "md:col-span-2" : ""}>
      <Label htmlFor={field.key} className="text-sm font-medium">
        {field.label}
        {field.required && <span className="text-red-500 ml-1">*</span>}
      </Label>
      <div className="mt-1">
        {renderInput()}
        {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
      </div>
    </div>
  )
}
