/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack } from '@mantine/core';
import { theme } from '../mantine';
import Carousel from './Carousel';


function Home(){
  return (
    <MantineProvider theme={theme}>
	<Carousel/>
    </MantineProvider>
  )
}
export default Home;

const rootElement = document.getElementById('home')
const root = createRoot(rootElement);

root.render(<Home {...Object.assign({}, rootElement.dataset)} />);


