import React from 'react';
import { MantineProvider, Flex } from '@mantine/core';
import { Carousel } from '@mantine/carousel';

export default function CarouselWrap(){
  return (
    <div className="h-[70vh] flex w-screen">
      <Carousel withIndicators height="100%" width="100%" loop>
	{
	  [
	    {src: "https://images.firstpost.com/wp-content/uploads/2019/10/Intel-Core-i9-9900KS-5-GHz.jpg?im=FitAndFill=(1200,675)",alt: "cpu"},
	    {src: "https://www.pcworld.com/wp-content/uploads/2023/10/cpu-hub-100758206-orig.jpg?quality=50&strip=all",alt: "cpu"},
	    {src: "https://www.trustedreviews.com/wp-content/uploads/sites/54/2021/03/Intel-Rocker-Lake-2-e1615908186584.jpg",alt: "cpu"},
	    {src: "https://cdn.mos.cms.futurecdn.net/Ria5erNerXX8q9PbzyAZvG-1200-80.jpg",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpy7JuBoA2XoJkg7PaYSxJfbftdZ7mP_DDYQ&s",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKt-AiHYU2Ai2_jcRhqCmwD_O8wWxHuD_CDA&s",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw7VjNIGCKxcwZWjvZtiurmi1JWvCMqpXmZA&s",alt: "cpu"},
	    {src: "https://static0.gamerantimages.com/wordpress/wp-content/uploads/2023/08/best-budget-cpus-for-gaming-gamerant-recommended-feature-1.jpg",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnUZ2WS1LU0prKPg-asXmwNJMxfrq8sMaB-A&s",alt: "cpu"},
	].map((item, index) => (
	  <Carousel.Slide key={index}>
	    <img alt={item.alt} src={item.src} className="bg-no-repeat object-fill w-screen" />
	  </Carousel.Slide>
	))}
      </Carousel>
    </div>
  )
}
