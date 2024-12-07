import React from 'react';
import { Stack, Title, Button, NumberFormatter } from "@mantine/core";

export default function Sidebar({subtotal, delivery_cost, vat, total}){
  return (
    <Stack className="px-8 rounded-md py-10 w-[350px]">
      <Title>Summary</Title>
      <h3 decimal={2}>Subtotal:{Intl.NumberFormat('en-GB', { maximumSignificantDigits: 2, currency: 'GBP', style: "currency" }).format(subtotal)}</h3>
      <NumberFormatter decimal={2}>Delivery cost: {delivery_cost}</NumberFormatter>
      <NumberFormatter decimal={2}>VAT: {vat}</NumberFormatter>
      <hr/>
      <h3>Total: {total}</h3>
      <Button radius="xl" size="lg" component="a" href="/checkout">Checkout</Button>
    </Stack>
  )
}
