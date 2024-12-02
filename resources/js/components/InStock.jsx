import React from 'react'
import { Flex, Title } from '@mantine/core'

export function InStock({inStock,text="in stock"}){
  return (
    <Flex className="items-baseline gap-2">
      <div className={`${!inStock ? "bg-red-600" : "bg-main-green"} w-3 h-3 rounded-full`}></div>
      <Title order={4}>{!inStock && "not"} {text}</Title>
    </Flex>
  )
  
}
