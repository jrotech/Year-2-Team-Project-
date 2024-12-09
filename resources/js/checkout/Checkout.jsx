import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import Sidebar from './Sidebar';
import Form from './Form';
import {fetchBasket} from '../basket/fetchBasket';

function Checkout(props){
  const [basketItems,setBasketItems] = React.useState([]);
  const [total,setTotal] = React.useState(0);

  React.useEffect(() => {
    fetchBasket().then((basket) => {
      console.log(basket);
      setTotal(basket.total);
      setBasketItems(basket.cartItems);
    });
  }, []);

  const handleCheckout = async (personalDetails) => {
    try {
      const response = await fetch('/api/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
          address: personalDetails.address,
          postcode: personalDetails.postal_code,
          basket: basketItems,
        }),
      });

      const result = await response.json();

      if (response.ok) {
     //   alert('Order successfully created!');
      } else {
      //  alert('Error creating order: ' + result.message);
      }
    } catch (error) {
      console.error('Error processing checkout:', error);
     // alert('Error processing checkout. Please try again.');
    }
  };
  
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center relative mt-28" gap="50">
      <Form onCheckout={handleCheckout} />
	<Sidebar vat={total*0.2} total={total*1.3} basketItems={basketItems} delivery_cost={total*0.1}/>
      </Flex>
    </MantineProvider>
  )
}

export default Checkout;

const rootElement = document.getElementById('checkout')
const root = createRoot(rootElement);

root.render(<Checkout {...Object.assign({}, rootElement.dataset)} />);


