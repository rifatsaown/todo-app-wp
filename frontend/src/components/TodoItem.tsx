import { Button } from '@/components/ui/button';
import { Todo } from '@/hooks/useTodos';
import { cn } from '@/lib/utils';
import { Check, Trash2 } from 'lucide-react';

interface TodoItemProps {
  todo: Todo;
  onToggle: (id: string) => void;
  onDelete: (id: string) => void;
}

export function TodoItem({ todo, onToggle, onDelete }: TodoItemProps) {
  return (
    <div className="flex items-center justify-between p-4 border rounded-md mb-2 bg-white">
      <div className="flex items-center space-x-2">
        <Button
          variant="outline"
          size="icon"
          className={cn(
            'rounded-full h-6 w-6 p-0',
            todo.completed && 'bg-primary text-primary-foreground'
          )}
          onClick={() => onToggle(todo.id)}
        >
          {todo.completed && <Check className="h-4 w-4" />}
        </Button>
        <span
          className={cn(
            'text-sm',
            todo.completed && 'line-through text-muted-foreground'
          )}
        >
          {todo.text}
        </span>
      </div>
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onDelete(todo.id)}
        className="h-8 w-8 text-destructive hover:bg-destructive/10"
      >
        <Trash2 className="h-4 w-4" />
      </Button>
    </div>
  );
}
