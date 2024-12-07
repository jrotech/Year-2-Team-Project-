import React from 'react';
import { createRoot } from 'react-dom/client';
import { useEffect, useState } from 'react';

import Images from './Image';
import { Flex, MantineProvider, Stack } from '@mantine/core';
import { ModalsProvider } from '@mantine/modals';
import { theme } from '../mantine';
import Info from './Info';
import Footer from './Footer';
import Feedback from './Feedback';

function Product(props){
  const [product, setProduct] = React.useState(JSON.parse(props.product))

  console.log(product)

  return (
    <MantineProvider theme={theme}>
      <Stack className="bg-main-bg py-24 px-16 justify-center w-screen">
	<Flex gap="50" wrap="wrap" justify="center">
	  <Images images={product.images.map( img => ({src: img.url, alt: img.alt}))} />
	  <ModalsProvider>
	    <Info productName={product.name} inStock={product.in_stock} rating={3}
			       price={product.price} id={product.id}
			       description={product.description} />
	  </ModalsProvider>
	</Flex>
	<Footer description={`
Imperdiet proin fermentum leo vel orci porta. Feugiat scelerisque varius morbi enim nunc, faucibus a pellentesque sit amet, porttitor eget dolor morbi non arcu risus, quis varius quam quisque id.
Egestas purus viverra accumsan in. Ut eu sem integer vitae justo eget magna fermentum iaculis eu non diam phasellus vestibulum lorem sed risus ultricies tristique nulla aliquet enim tortor, at?
Scelerisque varius morbi enim nunc, faucibus a pellentesque sit amet, porttitor eget dolor morbi non arcu risus, quis varius quam quisque id diam. Pellentesque sit amet, porttitor eget dolor morbi.
Laoreet suspendisse interdum consectetur libero, id faucibus nisl tincidunt eget nullam non nisi est, sit amet facilisis magna etiam tempor. In fermentum et, sollicitudin ac orci phasellus egestas tellus rutrum.
Suscipit adipiscing bibendum est ultricies integer quis auctor elit sed vulputate mi sit amet mauris commodo quis imperdiet massa. Tincidunt arcu, non sodales neque sodales ut etiam sit amet nisl!
Augue ut lectus arcu, bibendum at varius vel, pharetra. Hac habitasse platea dictumst quisque sagittis, purus sit amet volutpat consequat, mauris nunc congue nisi, vitae suscipit tellus mauris a diam?
Ut porttitor leo a diam sollicitudin tempor id eu nisl nunc mi ipsum, faucibus vitae aliquet nec, ullamcorper sit amet risus nullam eget felis eget. Cursus vitae congue mauris rhoncus!
Sagittis id consectetur purus ut faucibus pulvinar elementum integer enim neque, volutpat ac tincidunt! Nunc, sed blandit libero volutpat sed cras ornare arcu dui vivamus arcu felis, bibendum ut tristique.
Pharetra convallis posuere morbi leo urna, molestie at elementum eu? Arcu dui vivamus arcu felis, bibendum ut tristique et, egestas quis ipsum suspendisse ultrices gravida dictum fusce ut placerat orci!
Dignissim sodales ut eu sem integer vitae justo eget magna fermentum iaculis eu non diam phasellus vestibulum lorem sed. Diam maecenas ultricies mi eget mauris pharetra et ultrices neque ornare?
	`} />
	<Feedback/>
      </Stack>
    </MantineProvider>
  )
}

export default Product;

const rootElement = document.getElementById('product')
const root = createRoot(rootElement);

root.render(<Product {...Object.assign({}, rootElement.dataset)} />);


