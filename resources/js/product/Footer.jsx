import React from 'react'
import { Title, Text, Stack } from '@mantine/core'

export default function Footer({description}){
  return (
    <Stack className="w-[70vw]">
      <Title>Description</Title>
      <Text>{description}</Text>
    </Stack>
  )
}
