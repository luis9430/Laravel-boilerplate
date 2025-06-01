// assets/js/components/AdminPageApp.jsx

// No necesitas 'import { h } from "preact";' si tienes el runtime automático de JSX configurado
import { Paper, Title, Text, Divider, SimpleGrid, Badge } from '@mantine/core';

function AdminPageApp(props) {
  // Los datos vienen de window.wpLaravelAdminData, pasados como props.config en admin.js
  const { currentUser, pluginInfo, woocommerce, pluginApiUrl } = props.config;

  return (
    <Paper shadow="md" p="lg" radius="md">
      <Title order={2} mb="md">
        {pluginInfo?.name || 'Panel del Plugin'} (v{pluginInfo?.version || 'N/A'})
      </Title>
      
      <Text mb="sm">
        ¡Hola, {currentUser?.name || 'Usuario'}! (ID: {currentUser?.id || 'N/A'})
      </Text>
      <Text size="sm" color="dimmed" mb="md">
        URL de la API del Plugin: {pluginApiUrl || 'No configurada'}
      </Text>

      <Divider my="lg" label="Información de WooCommerce" labelPosition="center" />

      {woocommerce?.is_active ? (
        <SimpleGrid cols={2} spacing="md">
          <Paper withBorder p="sm" radius="sm">
            <Text weight={500}>Estado de WooCommerce:</Text>
            <Badge color="green" variant="light">Activo</Badge>
          </Paper>
          <Paper withBorder p="sm" radius="sm">
            <Text weight={500}>Símbolo de Moneda:</Text>
            <Text>{woocommerce.currency_symbol || 'N/A'}</Text>
          </Paper>
          <Paper withBorder p="sm" radius="sm">
            <Text weight={500}>Cantidad de Productos (publicados):</Text>
            <Text>{typeof woocommerce.product_count !== 'undefined' ? woocommerce.product_count : 'N/A'}</Text>
          </Paper>
        </SimpleGrid>
      ) : (
        <Paper withBorder p="sm" radius="sm" style={{ textAlign: 'center' }}>
          <Badge color="red" variant="light" size="lg">WooCommerce no está activo</Badge>
        </Paper>
      )}

      {/* Aquí podrías añadir más componentes y lógica */}
    </Paper>
  );
}

export default AdminPageApp;