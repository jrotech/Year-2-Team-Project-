import React from 'react';
import { createRoot } from 'react-dom/client';
import Images from './Image';
import { Flex, MantineProvider, Stack } from '@mantine/core';
import { ModalsProvider } from '@mantine/modals';
import { theme } from '../mantine';
import Info from './Info';
import Footer from './Footer';
import Feedback from './Feedback';

function Product(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Stack className="bg-main-bg py-24 px-16 justify-center w-screen">
	<Flex gap="50" wrap="wrap" justify="center">
	  <Images images={[
	    {src: "https://images.firstpost.com/wp-content/uploads/2019/10/Intel-Core-i9-9900KS-5-GHz.jpg?im=FitAndFill=(1200,675)",alt: "cpu"},
	    {src: "https://www.pcworld.com/wp-content/uploads/2023/10/cpu-hub-100758206-orig.jpg?quality=50&strip=all",alt: "cpu"},
	    {src: "https://www.trustedreviews.com/wp-content/uploads/sites/54/2021/03/Intel-Rocker-Lake-2-e1615908186584.jpg",alt: "cpu"},
	    {src: "https://cdn.mos.cms.futurecdn.net/Ria5erNerXX8q9PbzyAZvG-1200-80.jpg",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpy7JuBoA2XoJkg7PaYSxJfbftdZ7mP_DDYQ&s",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKt-AiHYU2Ai2_jcRhqCmwD_O8wWxHuD_CDA&s",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw7VjNIGCKxcwZWjvZtiurmi1JWvCMqpXmZA&s",alt: "cpu"},
	    {src: "https://static0.gamerantimages.com/wordpress/wp-content/uploads/2023/08/best-budget-cpus-for-gaming-gamerant-recommended-feature-1.jpg",alt: "cpu"},
	    {src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnUZ2WS1LU0prKPg-asXmwNJMxfrq8sMaB-A&s",alt: "cpu"},
	    
	    
	  ]} />
	  <ModalsProvider>
	    <Info productName="InterCore I9" inStock={true} rating={3}
			       price={9999999999}
			       description={`
	  Neque laoreet suspendisse interdum consectetur libero, id faucibus nisl tincidunt eget nullam non nisi est, sit amet facilisis? Viverra aliquet eget sit amet tellus cras adipiscing enim eu turpis egestas.
	  Aliquam vestibulum morbi blandit cursus risus, at ultrices mi tempus imperdiet nulla. Enim ut tellus elementum sagittis vitae et leo duis ut diam quam nulla porttitor massa id neque aliquam?
	  Diam donec adipiscing tristique risus nec feugiat in fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed pulvinar proin! Nibh mauris, cursus mattis molestie a, iaculis at erat pellentesque.
			       `} />
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


