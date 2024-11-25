import React from 'react';
import { Title, Button, Flex, Stack } from "@mantine/core";
import {Stars} from '../components/Stars'

export default function Product({name,img,price,inStock,rating,id,wishList}){
  return (
    <Stack className="bg-white w-80 rounded-md relative px-12 py-8 gap-7 hover:bg-main-bg transition-color duration-300">
      <div className="absolute top-3 right-3 cursor-pointer">
	<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24" stroke="currentColor" fill={wishList ? "#FF0707" : "none"} strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="hover:fill-[#FF0707] transition-colors duration-300 icon icon-tabler icons-tabler-outline icon-tabler-heart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
      </div>
      <Title order={2} className="text-center">{name}</Title> 
      <img alt="" src={img} className="w-40" />

      <Stars rating={rating} />

      <Flex className="items-baseline gap-2">
	<div className={`${!inStock ? "bg-red-600" : "bg-main-green"} w-3 h-3 rounded-full`}></div>
	<Title order={4}>{!inStock && "not"} in stock</Title>
      </Flex>

      <Flex>
	<Title order={3}>
	  {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 2,currency: 'GBP', style: "currency"}).format(price)}
	</Title>
      </Flex>
      
      <Button className="!w-36 !rounded-md" component="a" href={`/shop/product/${id}`}>See More</Button>
    </Stack>
  )
}
