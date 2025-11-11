import Welcome from '@/pages/Welcome.vue'
import { describe, expect, it } from 'vitest'

describe('Welcome component', () => {
  it('dummy test', () => {
    expect(true).toBe(true)
    expect(Welcome).toBeTruthy()
  })
})
