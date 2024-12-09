/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react';
import { MantineProvider, Flex } from '@mantine/core';
import { Carousel } from '@mantine/carousel';

export default function CarouselWrap(){
  return (
    <div className="h-[70vh] flex w-screen">
      <Carousel withIndicators height="100%" width="100%" loop>
	{
	  [
	   
	    {src: "/storage/categories/cpu.jpg",alt: "cpu"},
	    {src: "/storage/categories/gpu.jpg",alt: "gpu"},
	    {src: "/storage/categories/motherboard.jpg",alt: "motherboard"},
	    {src: "/storage/categories/ram.jpg",alt: "ram"},

	].map((item, index) => (
	  <Carousel.Slide key={index}>
	    <img alt={item.alt} src={item.src} className="bg-no-repeat object-fill w-screen" />
	  </Carousel.Slide>
	))}
      </Carousel>
    </div>
  )
}
