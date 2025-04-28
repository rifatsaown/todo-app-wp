# Todo App Plugin for WordPress

A simple WordPress plugin that adds a Todo App functionality to the WordPress Admin Panel using React, Vite, TailwindCSS, and Shadcn UI.

## Features

- Clean, modern UI built with Shadcn UI components
- Add, toggle, and delete todo items
- LocalStorage persistence (todos persist across page refreshes)
- Fully responsive design

## Structure

The plugin is separated into two main parts:

1. **Backend (WordPress Plugin)**: Minimal PHP code that registers the plugin, enqueues the necessary assets, and provides a mount point for the React app.
2. **Frontend (React App)**: A complete React application built with Vite, TypeScript, TailwindCSS, and Shadcn UI.

## Development Setup

### Prerequisites

- WordPress installation
- Node.js (v16+)
- npm or yarn

### Frontend Development

```bash
# Navigate to the frontend directory
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev
```

During development, you can work on the React app independently from WordPress. The Vite dev server will run on http://localhost:3000.

### Building for Production

```bash
# Navigate to the frontend directory
cd frontend

# Build the React app
npm run build
```

This will create production-ready files in the `frontend/public` directory, which will be served by WordPress.

## Installation in WordPress

1. Zip the entire plugin directory:

   ```bash
   cd path/to/plugin-parent-directory
   zip -r todo-app-plugin.zip todo-app-plugin
   ```

2. In your WordPress admin panel, go to Plugins > Add New > Upload Plugin, and upload the zip file.

3. Activate the plugin.

4. You'll find the Todo App in the WordPress admin menu.

## Customization

- **Styling**: The plugin uses TailwindCSS with Shadcn UI components. You can customize the appearance by modifying the CSS variables in `frontend/src/index.css`.
- **Functionality**: The main logic for the todo app is in the `useTodos.ts` hook.

## Future Improvements

- Add database integration to store todos on the server
- Add user-specific todos
- Add filtering and sorting options
- Add due dates and priorities for todos

## License

GPL v2 or later
