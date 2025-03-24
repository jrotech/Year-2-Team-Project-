/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react';
import { MantineProvider, Flex } from '@mantine/core';
import { Carousel } from '@mantine/carousel';

export default function CarouselWrap(){
  const 
  return (
    <div className="flex w-screen md:justify-center md:items-center mt-[150px]">
    <Carousel
      withIndicators
      height={200}
      slideSize={{ base: '100%', sm: '50%', md: '33.333333%' }}
      slideGap={{ base: 0, sm: 'md' }}
      loop
      align="start"
    >	{
	  [
	   
	    {src: "/storage/categories/cpu.jpg",alt: "cpu"},
	    {src: "/storage/categories/gpu.jpg",alt: "gpu"},
	    {src: "/storage/categories/motherboard.jpg",alt: "motherboard"},
	    {src: "/storage/categories/ram.jpg",alt: "ram"},

	].map((item, index) => (
	  <Carousel.Slide key={index}>
	  <img alt={item.alt} src={item.src} className="bg-no-repeat object-fill" />
	  </Carousel.Slide>
	))}
      </Carousel>
    </div>
  )
}
