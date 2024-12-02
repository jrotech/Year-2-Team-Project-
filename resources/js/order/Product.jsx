import React from 'react';
import { Stack, Flex, NumberFormatter, Title, Button } from "@mantine/core";
import { InStock } from '../components/InStock';

export default function Product(props){
  return (
    <Flex className="bg-white p-6 rounded-md " gap="50">
      <img alt="" src="https://pngimg.com/d/cpu_PNG19.png" className="h-36" />
      <Stack className="w-[500px] max-w-[500px]">
	<Title order={4}>{props.title}</Title>
	<Flex gap="20" className="items-between justify-between w-full">
	  <Stack gap="2">
	    <label>Unit Price</label>
	    <NumberFormatter prefix="$ " value={props.unit_price} thousandSeparator />
	  </Stack>
	  <Stack gap="2">
	    <label>Unit Price</label>
	    <NumberFormatter prefix="$ " value={props.unit_price} thousandSeparator />
	  </Stack>
	  <Stack gap="2">
	    <label>Unit Price</label>
	    <NumberFormatter prefix="$ " value={props.unit_price} thousandSeparator />
	  </Stack>
	</Flex>
	<InStock inStock={true} />
	<Flex>
	  <Button variant="transparent">
	    Return
	    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
	  </Button>
	  <Button variant="transparent">
	    Rate
	    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
	  </Button>
	  <Button variant="transparent">
	    Order Again
	    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
	  </Button>

	</Flex>
      </Stack>
    </Flex>
  )
}
