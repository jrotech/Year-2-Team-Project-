import React from 'react';
import { Stack, Flex, Button, NumberFormatter, NumberInput, Title, Text } from '@mantine/core';

export default function Product({id,name,price,description,category,img_url, quantity}){
  const [qty, setQty] = React.useState(quantity);
  const [showDescription, setShowDescription] = React.useState(false);
  
  function handleDelete(){
    
  }

  return (
    <Stack className="px-4 py-4 max-w-[700px] rounded-md border-b-2 border-black">
      <Title order={4}>{name}</Title>
      <Flex gap="40">
	<Stack className="flex-1">
	  <img alt="" src={img_url} className="w-40" />
	</Stack>
	<Stack className="flex-[2]">
	  <Text lineClamp={showDescription ? 0 : 3} onClick={() => setShowDescription(!showDescription) }>{description}</Text>
	  <Title order={6}>{category}</Title>
	  <NumberInput value={qty} onChange={setQty} className="w-20 rounded-md" min={1} max={100} label="Quantity"
		       leftSection={
		       qty == 1 ?
		       <button onClick={(e) =>{e.preventDefault();qty != 1 ? setQty(qty-1) : null}} >
			 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
		       </button>
		       :
		       <button onClick={(e) =>{e.preventDefault();setQty(qty-1)}} >
			 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-circle-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l6 0" /></svg>
		       </button>
		       }
		       rightSection={
			 <button onClick={(e) =>{e.preventDefault();qty < 100 ? setQty(qty+1) : null}} variant="transparent" className="mr-2">
			   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>
			 </button>
		       }
	  />
	  
	</Stack>
	<NumberFormatter prefix="$ " decimalScale={2} value={price*qty} thousandSeparator />
      </Flex>
      

      
    </Stack>
  )
}
