import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { theme } from '../mantine';
import { MantineProvider, Flex, Stack, Title, Button, Center } from '@mantine/core';
import Product from './Product';
import Sidebar from './Sidebar'; 

function Basket() {
  const [basketItems, setBasketItems] = useState([]);
  const [total, setTotal] = useState(0);

  const clearBasket = async () => {
      try{
	const req = await fetch('/api/basket', {
	  headers: {
	    'Accept': 'application/json', 
	  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	},
	  method: "DELETE",
	})
	const res = await req.json();
	fetchBakset();
      }catch(e){
	console.log(e)
      }
    }

  const fetchBakset = async () => {
    try {
      const req = await fetch('/api/basket', {headers: {'Accept': 'application/json',},})
      const res = await req.json();
      console.log(res)
      setBasketItems(res.cartItems)
      setTotal(res.total)
    }catch(e){
      console.log(e)
    }

  }

  useEffect(() => {
    fetchBakset()
  }, []);

  const handleQuantityChange = (id, newQuantity) => {
    // Update the quantity in the basket
    setBasketItems((prevItems) =>
      prevItems.map((item) =>
        item.id === id ? { ...item, quantity: newQuantity } : item
      )
    );

    // Recalculate the total
    const newTotal = basketItems.reduce((acc, item) => {
      if (item.id === id) {
        return acc + item.price * newQuantity;
      }
      return acc + item.price * item.quantity;
    }, 0);
    setTotal(newTotal);
  };


  return (
    <MantineProvider theme={theme}>
      <Stack>
      <Flex className="max-w-screen justify-center relative mt-28" gap="30">
        <Stack>
	  {basketItems.length === 0 && <Title>Your basket is empty</Title>}
          {basketItems.map((item) => {

	    if(item.price == 0) return null
	    return (
            <Product
	      onChangeProduct={fetchBakset}
              key={item.id}
              id={item.id}
              name={item.name}
              price={item.price}
              description={item.description}
              category={item.category}
              img_url={item.img_url}
              quantity={item.quantity}
              onQuantityChange={handleQuantityChange} // Pass the callback
            />
	    )
          })}
          <Title>Total: ${total.toFixed(2)}</Title>
        </Stack>
        <Sidebar total={total} vat={total*0.2} delivery_cost={total*0.1} subtotal={total*0.7 } />
      </Flex>
      <Center>
	<Button onClick={clearBasket} color="red">Clear Basket</Button>
      </Center>
      </Stack>
    </MantineProvider>
  );
}

export default Basket;

const rootElement = document.getElementById('basket');
const root = createRoot(rootElement);

root.render(<Basket />);
