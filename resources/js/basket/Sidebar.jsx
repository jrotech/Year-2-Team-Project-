/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React, { useState } from 'react';
import { Stack, Title, Button, Text, List, ThemeIcon, Loader } from "@mantine/core";
import IconCheck from '@tabler/icons-react/dist/esm/icons/IconCheck.mjs';


export default function Sidebar({ subtotal, delivery_cost, vat, total, compatibilityStatements, loadingCompatibility }) {
  const [showCompatibility, setShowCompatibility] = useState(false);

  return (
    <Stack className="px-8 rounded-md py-10 w-[350px]">
      <Title>Summary</Title>
      <h3 decimal={2}>
        Subtotal: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(subtotal)}
      </h3>
      <h3 decimal={2}>
        Delivery cost: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(delivery_cost)}
      </h3>
      <h3 decimal={2}>
        VAT: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(vat)}
      </h3>
      <hr />
      <h2 decimal={2}>
        Total: {Intl.NumberFormat('en-GB', { maximumSignificantDigits: 6, currency: 'GBP', style: "currency" }).format(total)}
      </h2>
      <Button radius="xl" size="lg" component="a" href="/checkout">
        Checkout
      </Button>
      
      {/* Compatibility Check Section */}
      <Stack className="mt-4">
        <Button
          radius="xl"
          size="lg"
          variant="outline"
          onClick={() => setShowCompatibility(!showCompatibility)}
        >
          Check Compatibility
        </Button>

        {showCompatibility && (
          <List spacing="sm">
            {loadingCompatibility ? (
              <Loader size="sm" />
            ) : (
              compatibilityStatements.length > 0 ? (
                compatibilityStatements.map((statement, index) => (
                  <List.Item key={index} icon={<ThemeIcon color="green" radius="m"><IconCheck size={16} /></ThemeIcon>}>
                    <Text c="green">{statement}</Text>
                  </List.Item>
                ))
              ) : (
                <Text c="gray">No compatibility issues found.</Text>
              )
            )}
          </List>
        )}
      </Stack>
    </Stack>
  );
}
