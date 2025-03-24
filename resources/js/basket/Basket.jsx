import React, { useEffect, useState, useRef } from 'react';
import { createRoot } from 'react-dom/client';
import { theme } from '../mantine';
import {
  MantineProvider,
  Flex,
  Stack,
  Title,
  Button,
  Center,
  Loader,
  Transition,
} from '@mantine/core';
import Product from './Product';
import Sidebar from './Sidebar';
import { fetchBasket as getBasket } from './fetchBasket';
import { fetchCompatibility } from './fetchCompatibility';
import CompatibilityBlock from './CompatibilityBlock';

function Basket() {
  const [basketItems, setBasketItems] = useState([]);
  const [total, setTotal] = useState(0);
  const [compatibilityBlocks, setCompatibilityBlocks] = useState([]);
  const [compatibilityLoading, setCompatibilityLoading] = useState(false);
  const [showBlocks, setShowBlocks] = useState(false);

  // Ref for the compatibility blocks container
  const blocksRef = useRef(null);

  const fetchBasket = async () => {
    const basket = await getBasket();
    setBasketItems(basket.cartItems);
    setTotal(basket.total);
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

  const checkCompatibility = async () => {
    setCompatibilityLoading(true);
    setShowBlocks(false); // Hide blocks while loading
    // Send product IDs and quantities
    const response = await fetchCompatibility(basketItems);
    setCompatibilityBlocks(response.compatibility_blocks || []);
    setCompatibilityLoading(false);
    setShowBlocks(true);
  };

  // When the compatibility blocks become visible, scroll them into view
  
useEffect(() => {
  if (showBlocks && compatibilityBlocks.length > 0 && blocksRef.current) {
    // Wait until the transition is finished (600ms + a little extra) before scrolling.
    setTimeout(() => {
      blocksRef.current.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
  }
}, [showBlocks, compatibilityBlocks]);


  useEffect(() => {
    fetchBasket();
  }, []);

  return (
    <MantineProvider theme={theme}>
      <Stack spacing="lg">
        {/* Main Content */}
        <Flex className="max-w-screen justify-center relative mt-4 mb-20" gap="30">
          <Stack>
            <Flex justify="flex-start" p="md">
              <Button onClick={clearBasket} color="red" variant="outline">Clear Basket</Button>
            </Flex>
            {basketItems.length === 0 && <Title>Your basket is empty</Title>}
            {basketItems.map(
              (item) =>
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
            )}
            <Title>Subtotal: £{total.toFixed(2)}</Title>
            <Button onClick={checkCompatibility} fullWidth mt="md">
              Check Compatibility
            </Button>
            {compatibilityLoading && (
              <Center mt="md" style={{ minHeight: 700 }}>
                <Loader variant="dots" />
              </Center>
            )}
            <Transition mounted={!compatibilityLoading && showBlocks} transition="fade" duration={600}>
              {(styles) => (
                <div style={styles} ref={blocksRef}>
                  <Stack mt="md">
                    {compatibilityBlocks.map((block, index) => (
                      <CompatibilityBlock key={index} block={block} basketItems={basketItems} />
                    ))}
                  </Stack>
                </div>
              )}
            </Transition>
          </Stack>
          <Sidebar
            total={total * 1.3}
            vat={total * 0.2}
            delivery_cost={total * 0.1}
            subtotal={total}
          />
        </Flex>
      </Stack>
    </MantineProvider>
  );
}

export default Basket;

const rootElement = document.getElementById('basket');
const root = createRoot(rootElement);
root.render(<Basket />);
