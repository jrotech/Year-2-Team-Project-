/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react';
import { MantineProvider, Flex } from '@mantine/core';
import { Carousel } from '@mantine/carousel';

import { useState, useEffect } from 'react';

export default function CarouselWrap(){
  const [windowSize, setWindowSize] = useState({
    width: window.innerWidth,
    height: window.innerHeight
  });

  useEffect(() => {
    // Handler to call on window resize
    function handleResize() {
      setWindowSize({
        width: window.innerWidth,
        height: window.innerHeight
      });
    }
    
    // Add event listener
    window.addEventListener('resize', handleResize);
    
    // Call handler right away so state gets updated with initial window size
    handleResize();
    
    // Remove event listener on cleanup
    return () => window.removeEventListener('resize', handleResize);
  }, []); // Empty array ensures that effect is only run on mount and unmount

  console.log(windowSize);
  return (
    <div className="flex w-screen md:justify-center md:items-center mt-[150px]">
    <Carousel
      withIndicators
      height={windowSize.width > 720 ? 400 : 200}
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
