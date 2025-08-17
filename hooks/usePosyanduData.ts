"use client"

import { useState, useEffect } from "react"
import type { PosyanduData } from "@/types/posyandu"

export function usePosyanduData() {
  const [data, setData] = useState<PosyanduData[]>([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  const fetchData = async () => {
    try {
      setIsLoading(true)
      setError(null)

      const response = await fetch("/api/posyandu")
      if (!response.ok) throw new Error("Gagal memuat data")

      const result = await response.json()
      setData(result)
    } catch (err) {
      setError(err instanceof Error ? err.message : "Terjadi kesalahan")
    } finally {
      setIsLoading(false)
    }
  }

  const createData = async (formData: Record<string, string>) => {
    const response = await fetch("/api/posyandu", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(formData),
    })

    if (!response.ok) throw new Error("Gagal menyimpan data")

    const newData = await response.json()
    setData((prev) => [newData, ...prev])
    return newData
  }

  const updateData = async (id: string, formData: Record<string, string>) => {
    const response = await fetch(`/api/posyandu/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(formData),
    })

    if (!response.ok) throw new Error("Gagal memperbarui data")

    const updatedData = await response.json()
    setData((prev) => prev.map((item) => (item.id === id ? updatedData : item)))
    return updatedData
  }

  const deleteData = async (id: string) => {
    const response = await fetch(`/api/posyandu/${id}`, {
      method: "DELETE",
    })

    if (!response.ok) throw new Error("Gagal menghapus data")

    setData((prev) => prev.filter((item) => item.id !== id))
  }

  useEffect(() => {
    fetchData()
  }, [])

  return {
    data,
    isLoading,
    error,
    refetch: fetchData,
    createData,
    updateData,
    deleteData,
  }
}

export function usePosyanduItem(id: string) {
  const [item, setItem] = useState<PosyanduData | null>(null)
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    const fetchItem = async () => {
      try {
        setIsLoading(true)
        setError(null)

        const response = await fetch(`/api/posyandu/${id}`)
        if (!response.ok) throw new Error("Data tidak ditemukan")

        const result = await response.json()
        setItem(result)
      } catch (err) {
        setError(err instanceof Error ? err.message : "Terjadi kesalahan")
      } finally {
        setIsLoading(false)
      }
    }

    if (id) fetchItem()
  }, [id])

  return { item, isLoading, error }
}
