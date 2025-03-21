/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react';
import { Stack, Flex, NumberFormatter, Title, Button } from "@mantine/core";
import { InStock } from '../components/InStock';

export default function Product(props){
  return (
    <Flex className="bg-white p-6 rounded-md " gap="50">
      <img alt="" src={props.img} className="h-36" />
      <Stack className="w-[500px] max-w-[500px]">
	<Title order={4}>{props.title}</Title>
	<Flex gap="20" className="items-between justify-between w-full">
	  <Stack gap="2">
	    <label>Unit Price</label>
	    <NumberFormatter prefix="£ " value={props.unit_price} thousandSeparator />
	  </Stack>
	</Flex>
	<InStock inStock={true} />
	{props.children}
      </Stack>
    </Flex>
  )
}
