import React from 'react';
import { Paper, Group, Avatar, Text, Title, Box, Stack, Flex } from '@mantine/core';

export default function CompatibilityBlock({ block, basketItems }) {
  // Helper: Look up full product details from basket items using product id.
  const getProductDetails = (product) => {
    if (!product || !product.id) return product;
    return basketItems.find((item) => item.id === product.id) || product;
  };

  // Default render for left/right sides.
  let leftContent = null;
  let rightContent = null;

  // Reusable function to render an item with image + title + description.
  const renderItem = (product) => (
    <Group spacing="sm" align="flex-start">
      {product.img_url ? (
        <Avatar src={product.img_url} size={60} radius="md" />
      ) : (
        <Avatar color="gray" size={60} radius="md">
          {product.name ? product.name.charAt(0) : 'N'}
        </Avatar>
      )}
      <Box style={{ maxWidth: 220 }}>
        <Title order={5}>{product.name}</Title>
        <Text
          size="sm"
          color="dimmed"
          style={{ wordBreak: 'break-word', whiteSpace: 'normal' }}
        >
          {product.description || 'No description'}
        </Text>
      </Box>
    </Group>
  );

  switch (block.block) {
    case 'Motherboard - CPU': {
      const mb = getProductDetails(block.motherboard);
      const cpu = getProductDetails(block.cpu);
      leftContent = renderItem(mb);
      rightContent = renderItem(cpu);
      break;
    }

    case 'CPU - Cooler': {
      const cpu = getProductDetails(block.cpu);
      const cooler = getProductDetails(block.cooler);
      leftContent = renderItem(cpu);
      rightContent = renderItem(cooler);
      break;
    }

    case 'Motherboard - RAM': {
      const mb = getProductDetails(block.motherboard);
      const ram = getProductDetails(block.ram);
      leftContent = renderItem(mb);
      rightContent = renderItem(ram);
      break;
    }

    case 'Motherboard - GPU': {
      const mb = getProductDetails(block.motherboard);
      const gpu = getProductDetails(block.gpu);
      leftContent = renderItem(mb);
      rightContent = renderItem(gpu);
      break;
    }

    case 'Motherboard - Storage': {
      // Left side is the motherboard.
      const mb = getProductDetails(block.motherboard);
      leftContent = renderItem(mb);

      // Right side: multiple storage devices.
      rightContent = (
        <Stack spacing="xs" align="flex-start">
          <Title order={6}>Storage Devices</Title>
          <Group spacing="md" align="flex-start">
            {block.storage && block.storage.length > 0 ? (
              block.storage.map((storage, idx) => {
                const details = getProductDetails(storage);
                return (
                  <Stack key={idx} spacing={2} align="center">
                    {details.img_url ? (
                      <Avatar src={details.img_url} size={50} radius="md" />
                    ) : (
                      <Avatar color="gray" size={50} radius="md">
                        {details.name ? details.name.charAt(0) : 'N'}
                      </Avatar>
                    )}
                    <Text
                      size="xs"
                      style={{ wordBreak: 'break-word', whiteSpace: 'normal' }}
                    >
                      {details.name}
                    </Text>
                  </Stack>
                );
              })
            ) : (
              <Text size="sm" color="dimmed">
                No storage devices
              </Text>
            )}
          </Group>
        </Stack>
      );
      break;
    }

    case 'PSU - Components': {
      // Left side: PSU details.
      const psu = getProductDetails(block.psu);
      leftContent = renderItem(psu);

      // Right side: Show CPU and/or GPU
      const cpu = block.cpu ? getProductDetails(block.cpu) : null;
      const gpu = block.gpu ? getProductDetails(block.gpu) : null;

      if (cpu && gpu) {
        rightContent = (
          <Group spacing="xl" align="flex-start">
            {renderItem(cpu)}
            {renderItem(gpu)}
          </Group>
        );
      } else if (cpu) {
        rightContent = renderItem(cpu);
      } else if (gpu) {
        rightContent = renderItem(gpu);
      } else {
        rightContent = <Text>No CPU/GPU info available</Text>;
      }
      break;
    }

    default: {
      // Fallback: Render left and right as unknown
      leftContent = <Text>Unknown Left</Text>;
      rightContent = <Text>Unknown Right</Text>;
    }
  }

  return (
    <Paper
      shadow="sm"
      p="lg"
      radius="md"
      withBorder
      mb="lg"
      style={{ margin: '1rem 0' }}
    >
      <Group position="apart" align="flex-start" spacing="xl">
        {/* Left side with minWidth to ensure some space */}
        <Box style={{ minWidth: 240 }}>{leftContent}</Box>

        {/* Middle message with limited width to wrap text */}
        <Box style={{ maxWidth: 300 }}>
          <Text align="center" weight={500} style={{ wordBreak: 'break-word' }} c={block.compatible ? 'green' : 'red'}>
            {block.message}
          </Text>
        </Box>

        {/* Right side with minWidth to ensure some space */}
        <Box style={{ minWidth: 240 }}>{rightContent}</Box>
      </Group>
    </Paper>
  );
}
