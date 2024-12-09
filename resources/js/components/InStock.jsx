/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react'
import { Flex, Title } from '@mantine/core'

export function InStock({inStock,text="in stock"}){
  return (
    <Flex className="items-baseline gap-2 flex-nowrap">
      <div className={`${!inStock ? "bg-red-600" : "bg-main-green"} w-3 h-3 rounded-full`}></div>
      <Title order={4} className="text-nowrap">{!inStock && "not"} {text}</Title>
    </Flex>
  )
  
}
