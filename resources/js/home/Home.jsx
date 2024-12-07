import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack } from '@mantine/core';
import { theme } from '../mantine';
import Carousel from './Carousel';
import Related from '../components/Related';
import Signup from './signup';

function Home(){
  return (
    <MantineProvider theme={theme}>
	<Carousel/>
	<Flex className="w-screen py-20" justify="space-around">
	  <img alt="" src="images/logo.png"  />
	  <Signup/> 
	</Flex>
	<Flex gap="50" className="overflow-x-auto bg-main-bg py-10 px-20" align="center" justify="center">
	  {
	    Array.from({length: 5}).map((_, index) => (
	      <Related img_url="https://www.acpcs.co.uk/cdn/shop/files/HYPE_4090_ILLUSTRATION_large.png?v=1728672733" name="pc" price="2000" description="sadf" rating={2} id={index} />
	    ))
	  }
	</Flex>
    </MantineProvider>
  )
}
export default Home;

const rootElement = document.getElementById('home')
const root = createRoot(rootElement);

root.render(<Home {...Object.assign({}, rootElement.dataset)} />);


