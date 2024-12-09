import React from 'react'
import { Flex, Stack, Button, Title } from '@mantine/core';
import {InStock} from '../components/InStock'

export default function Order({name,id,order_date,total,invoice_orders}) {
	const productsContainerRef = React.useRef(null);
  
	return (
	  <Flex className="bg-white rounded-md p-10" gap="20">
		<Stack>
		  <Title order={4}>{name}</Title>
		  <Title order={4}>{order_date}</Title>
		  <Title order={4}>Total - £{total}</Title>
		  <Title order={4} className="flex gap-2 flex-nowrap !whitespace-nowrap">
			Status - <InStock inStock ={true} text="complete" />
		  </Title>
		</Stack>
		<div className="w-[3px] bg-black"></div>
		<Flex className="overflow-x-hidden max-w-screen" gap="30"ref={productsContainerRef}>
			
		  {Array.isArray(invoice_orders) && invoice_orders.length > 0 ? (
			invoice_orders.map((product, i) => (
			  <Stack className="min-w-32" key={i} gap="5">
				{console.log(product.product.image)}
				<img alt="" src={"/storage/"+product.product.image} className="max-h-32" />
				<Title order={6} className="m-0">{product.product.name}</Title>
				<Title order={6} className="m-0">Quantity - {product.quantity}</Title>
				<Title order={6} className="m-0">Price - £{product.product.price}</Title>
			  </Stack>
			))
		  ) : (
			<p>No products found.</p>
		  )}
		</Flex>
		<Flex className="items-end relative">
		  <Button radius="xl" component="a" href={`/dashboard/orders/${id}`}>
			Details
			<svg
			  xmlns="http://www.w3.org/2000/svg"
			  width="24"
			  height="24"
			  viewBox="0 0 24 24"
			  fill="none"
			  stroke="currentColor"
			  strokeWidth="2"
			  strokeLinecap="round"
			  strokeLinejoin="round"
			  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"
			>
			  <path stroke="none" d="M0 0h24V24H0z" fill="none" />
			  <path d="M5 12l14 0" />
			  <path d="M13 18l6 -6" />
			  <path d="M13 6l6 6" />
			</svg>
		  </Button>
		</Flex>
	  </Flex>
	);
  }
  