import { TodoList } from '@/components/TodoList';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useTodos } from '@/hooks/useTodos';
import { PlusCircle } from 'lucide-react';
import React, { useState } from 'react';

export function App() {
  const { todos, addTodo, toggleTodo, deleteTodo } = useTodos();
  const [newTodoText, setNewTodoText] = useState('');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    addTodo(newTodoText);
    setNewTodoText('');
  };

  return (
    <div className="max-w-md mx-auto p-6">
      <div className="mb-8">
        <h2 className="text-2xl font-bold mb-1">Todo App</h2>
        <p className="text-muted-foreground text-sm">
          Manage your daily tasks efficiently
        </p>
      </div>

      <form onSubmit={handleSubmit} className="flex gap-2 mb-6">
        <Input
          value={newTodoText}
          onChange={(e) => setNewTodoText(e.target.value)}
          placeholder="Add a new task..."
          className="flex-1"
        />
        <Button type="submit" disabled={!newTodoText.trim()}>
          <PlusCircle className="h-4 w-4 mr-2" />
          Add
        </Button>
      </form>

      <TodoList todos={todos} onToggle={toggleTodo} onDelete={deleteTodo} />
    </div>
  );
}
