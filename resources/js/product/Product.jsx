/********************************
 Developer: Robert Oros, Hasnain Imran
 University ID: 230237144, 230209037
 ********************************/
import React from 'react';
import { createRoot } from 'react-dom/client';
import { Flex, MantineProvider, Stack, Title, Card,Text,Table, Paper, Divider, Container } from '@mantine/core';
import { ModalsProvider } from '@mantine/modals';
import { theme } from '../mantine';
import Images from './Image';
import Info from './Info';
import Footer from './Footer';
import Feedback from './Feedback';

function Product(props) {
<<<<<<< HEAD
  const [product, setProduct] = React.useState(JSON.parse(props.product));
  const parsedSpecs = JSON.parse(product.specifications);
=======
    const [product, setProduct] = React.useState(JSON.parse(props.product));
>>>>>>> origin/admin-feature

    return (
        <MantineProvider theme={theme}>
            <Container size="lg" className="py-24 px-16 bg-main-bg">
                {/* Product Section */}
                <Paper shadow="sm" radius="md" p="lg" withBorder>
                    <Flex gap="lg" wrap="wrap" justify="center" align="flex-start">
                        {/* Product Images */}
                        <Images images={product.images.map(img => ({ src: img.url, alt: img.alt }))} />

<<<<<<< HEAD
            {/* Product Info */}
            <ModalsProvider>
              <Info
                productName={product.name}
                inStock={product.in_stock}
                rating={3}
                price={product.price}
                id={product.id}
                description={product.description}
                specification={product.specification}
              />
            </ModalsProvider>
          </Flex>
        </Paper>
=======
                        {/* Product Info */}
                        <ModalsProvider>
                            <Info
                                productName={product.name}
                                inStock={product.in_stock}
                                rating={3}
                                price={product.price}
                                id={product.id}
                                description={product.description}
                            />
                        </ModalsProvider>
                    </Flex>
                </Paper>
>>>>>>> origin/admin-feature

                {/* Divider */}
                <Divider my="xl" size="sm" />

<<<<<<< HEAD
        {/* Footer */}
        
        <Paper shadow="sm" radius="md" p="lg" withBorder>
      <Card shadow="sm" padding="lg" radius="md" withBorder>
        <Stack>
          <Title order={3} mt="md">Specifications</Title>
          <Table striped highlightOnHover withBorder>
            <thead>
              <tr>
                <th className="text-left">Category</th>
                <th className="text-left">Feature</th>
                <th className="text-left">Value</th>
              </tr>
            </thead>
            <tbody>
              {Object.entries(parsedSpecs).map(([category, specs]) => {
                const specEntries = Object.entries(specs);
                return specEntries.map(([feature, value], index) => (
                  <tr key={`${category}-${feature}-${index}`}>
                    {index === 0 && (
                      <td rowSpan={specEntries.length} style={{ fontWeight: 'bold', verticalAlign: 'top' }}>
                        {category}
                      </td>
                    )}
                    <td>{feature}</td>
                    <td>{value}</td>
                  </tr>
                ));
              })}
            </tbody>
          </Table>
        </Stack>
      </Card>
    </Paper>
=======
                {/* Footer */}
                <Paper shadow="sm" radius="md" p="lg" withBorder>
                    <Footer
                        description={`
            Imperdiet proin fermentum leo vel orci porta. Feugiat scelerisque varius morbi enim nunc, faucibus a pellentesque sit amet, porttitor eget dolor morbi non arcu risus, quis varius quam quisque id.
            Egestas purus viverra accumsan in. Ut eu sem integer vitae justo eget magna fermentum iaculis eu non diam phasellus vestibulum lorem sed risus ultricies tristique nulla aliquet enim tortor, at?
            `}
                    />
                </Paper>
>>>>>>> origin/admin-feature

                {/* Divider */}
                <Divider my="xl" size="sm" />

                {/* Feedback Section */}
                <Paper shadow="sm" radius="md" p="lg" withBorder>
                    <Feedback productId={product.id} />
                </Paper>
            </Container>
        </MantineProvider>
    );
}

export default Product;

const rootElement = document.getElementById('product');
const root = createRoot(rootElement);

root.render(<Product {...Object.assign({}, rootElement.dataset)} />);
