'use client'

import { useEffect, useState } from 'react'
import { supabase } from '@/lib/supabase'
import { useRouter } from 'next/navigation'

export default function Dashboard() {
  const [user, setUser] = useState<any>(null)
  const [score, setScore] = useState(0)
  const [leaderboard, setLeaderboard] = useState<any[]>([])
  const router = useRouter()

  useEffect(() => {
    const getUser = async () => {
      const { data: { user } } = await supabase.auth.getUser()
      if (!user) {
        router.push('/login')
        return
      }
      setUser(user)
      fetchScore(user.email!)
      fetchLeaderboard()
    }
    getUser()
  }, [router])

  const fetchScore = async (email: string) => {
    const { data, error } = await supabase
      .from('scores')
      .select('score')
      .eq('email', email)
      .single()
    if (data) setScore(data.score)
  }

  const fetchLeaderboard = async () => {
    const { data, error } = await supabase
      .from('scores')
      .select('email, score')
      .order('score', { ascending: false })
      .limit(10)
    if (data) setLeaderboard(data)
  }

  const handleClick = async () => {
    if (!user) return
    const newScore = score + 1
    setScore(newScore)
    await supabase
      .from('scores')
      .update({ score: newScore })
      .eq('email', user.email)
    fetchLeaderboard()
  }

  const handleLogout = async () => {
    await supabase.auth.signOut()
    router.push('/login')
  }

  if (!user) return <div>Loading...</div>

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-4xl mx-auto py-8 px-4">
        <div className="bg-white shadow rounded-lg p-6">
          <div className="flex justify-between items-center mb-6">
            <h1 className="text-2xl font-bold">Dashboard</h1>
            <button
              onClick={handleLogout}
              className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            >
              Logout
            </button>
          </div>

          <div className="mb-6">
            <button
              onClick={handleClick}
              className="bg-green-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-green-600"
            >
              CLICK ME
            </button>
          </div>

          <div className="mb-6">
            <h2 className="text-xl font-semibold mb-2">Your Score: {score}</h2>
          </div>

          <div>
            <h2 className="text-xl font-semibold mb-4">Leaderboard</h2>
            <table className="w-full table-auto">
              <thead>
                <tr className="bg-gray-200">
                  <th className="px-4 py-2 text-left">Email</th>
                  <th className="px-4 py-2 text-left">Score</th>
                </tr>
              </thead>
              <tbody>
                {leaderboard.map((entry, index) => (
                  <tr key={index} className="border-b">
                    <td className="px-4 py-2">{entry.email}</td>
                    <td className="px-4 py-2">{entry.score}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  )
}