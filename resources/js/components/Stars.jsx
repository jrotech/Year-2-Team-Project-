//
// THIS COMPONENT USES MANTINE MAKE SURE THE COMPONENT HAS ACCESS TO MANTINE PROVIDER!!!!
//

import React from 'react';
import { useHover } from '@mantine/hooks';
import { Flex } from '@mantine/core';


export function Stars({rating=0}){
  
  return (
    <Flex gap="10">
      {[0,1,2,3,4].map((item, index) => (
	<div key={index}>
	{ index+1 <= rating ? 
	 <svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="#FFE100"  className="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
      :
	  <svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
	}
	</div>
      ))
      }
    </Flex>
  )
}

//This component is for selecting the rating
export function DynamicStars(){

  return (
    <Stars />
  )
}

