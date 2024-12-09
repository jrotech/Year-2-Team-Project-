/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/

import React from 'react';
import { Stack, Title, Button, NumberFormatter } from "@mantine/core";

export default function Sidebar({subtotal, delivery_cost, vat, total}){
  return (
    <Stack className="px-8 rounded-md py-10 w-[350px]">
      <Title>Summary</Title>
      <h3 decimal={2}>Subtotal:{Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(subtotal)}</h3>
      <h3 decimal={2}>Delivery cost: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(delivery_cost)}</h3>
      <h3 decimal={2}>VAT: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(vat)}</h3>
      <hr/>
      <h2 decimal={2}>Total: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(total)}</h2>
      <Button radius="xl" size="lg" component="a" href="/checkout">Checkout</Button>
    </Stack>
  )
}
