// Definição global do toast
declare global {
  interface Window {
    showToast?: (message: string, type?: 'success' | 'error' | 'warning' | 'info', delay?: number) => void;
    showConfirm?: (options: {
      title?: string;
      message: string;
      confirmText?: string;
      cancelText?: string;
      onConfirm?: () => void;
      onCancel?: () => void;
    }) => void;
  }
}

export {};
