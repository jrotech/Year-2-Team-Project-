import React from 'react';
import { Stack, Title, Button } from "@mantine/core";

export default function Sidebar({subtotal, delivery_cost, vat, total}){
  return (
    <Stack className="px-8 rounded-md py-10 w-[350px]">
      <Title>Summary</Title>
      <h3>Subtotal: {subtotal}</h3>
      <h3>Delivery cost: {delivery_cost}</h3>
      <h3>VAT: {vat}</h3>
      <hr/>
      <h3>Total: {total}</h3>
      <Button radius="xl" size="lg" component="a" href="/checkout">Checkout</Button>
    </Stack>
  )
}
