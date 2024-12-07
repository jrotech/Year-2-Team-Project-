import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import Sidebar from './Sidebar';
import Form from './Form';

function Checkout(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center relative mt-28" gap="50">
	<Form/>
	<Sidebar vat={3232} total={2302} />
      </Flex>
    </MantineProvider>
  )
}

export default Checkout;

const rootElement = document.getElementById('checkout')
const root = createRoot(rootElement);

root.render(<Checkout {...Object.assign({}, rootElement.dataset)} />);


