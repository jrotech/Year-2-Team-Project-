/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { theme } from '../mantine';
import { MantineProvider, Flex, Stack, Title, Button, Center } from '@mantine/core';
import Product from './Product';
import Sidebar from './Sidebar'; 
import { fetchBasket as getBasket } from './fetchBasket';

function Basket() {
  const [basketItems, setBasketItems] = useState([]);
  const [total, setTotal] = useState(0);
  const [compatibilityStatements, setCompatibilityStatements] = useState([]);
  const [loadingCompatibility, setLoadingCompatibility] = useState(false);

  const fetchBasket = async () => {
    const basket = await getBasket();
    setBasketItems(basket.cartItems);
    setTotal(basket.total);
    
    // Fetch compatibility statements from backend
    checkCompatibility(basket.cartItems);
  };

  const clearBasket = async () => {
    try {
      const req = await fetch('/api/basket', {
        headers: {
          'Accept': 'application/json', 
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: "DELETE",
      });
      await req.json();
      fetchBasket();
    } catch (e) {
      console.log(e);
    }
  };

  const checkCompatibility = async (products) => {
    setLoadingCompatibility(true);
    try {
      const productIds = products.map(product => product.id);
      
      const response = await fetch('/api/check-compatibility', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_ids: productIds })
      });

      const data = await response.json();
      setCompatibilityStatements(data.statements); // Assuming backend returns { statements: [...] }
    } catch (error) {
      console.error('Error fetching compatibility:', error);
      setCompatibilityStatements(['Failed to check compatibility']);
    } finally {
      setLoadingCompatibility(false);
    }
  };

  useEffect(() => {
    fetchBasket();
  }, []);

  return (
    <MantineProvider theme={theme}>
      <Stack>
        <Flex className="max-w-screen justify-center relative mt-28" gap="30">
          <Stack>
            {basketItems.length === 0 && <Title>Your basket is empty</Title>}
            {basketItems.map((item) => (
              item.price !== 0 && (
                <Product
                  onChangeProduct={fetchBasket}
                  key={item.id}
                  id={item.id}
                  name={item.name}
                  price={item.price}
                  description={item.description}
                  category={item.category}
                  img_url={item.img_url}
                  quantity={item.quantity}
                />
              )
            ))}
            <Title>Subtotal: £{total.toFixed(2)}</Title>
          </Stack>
          <Sidebar
            total={total * 1.3}
            vat={total * 0.2}
            delivery_cost={total * 0.1}
            subtotal={total}
            compatibilityStatements={compatibilityStatements}
            loadingCompatibility={loadingCompatibility}
          />
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
