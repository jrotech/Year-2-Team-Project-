import React from 'react'
import { Flex, Stack, Button, Title } from '@mantine/core';
import {InStock} from '../components/InStock'


export default function OrderProduct(props){

  const productsContainerRef = React.useRef(null)
  return (
    <Flex className="bg-white rounded-md p-10" gap="20">
      <Stack>
	<Title order={4}>{props.order_date}</Title>
	<Title order={4}>Total - {props.total}</Title>
	<Title order={4}>Status - <InStock text="complete" /></Title>
	
      </Stack>
      <div className="w-[3px] bg-black"></div>
      <Flex className="overflow-x-hidden max-w-screen w-[400px]" ref={productsContainerRef}>
	{
	  props.products.map((product,i) => (
	      <Stack className="min-w-32" key={i} gap="5">
		<img alt="" src={product.img_url} className="max-h-32" />
		<Title order={6} className="m-0">{product.name}</Title>
		<Title order={6} className="m-0">Quantity - {product.quantity}</Title>
		<Title order={6} className="m-0">Price - {product.unit_price}</Title>
	      </Stack>
	      )
	  )}
      </Flex>
    <Flex className="items-end relative">
      <button variant="transparent" className="absolute left-10 top-[45%]" >
<svg  xmlns="http://www.w3.org/2000/svg"  width="35"  height="35"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>

      </button>
      <Button radius="xl">
	Details
	<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
      </Button>
    </Flex>
    </Flex>
  )
}

