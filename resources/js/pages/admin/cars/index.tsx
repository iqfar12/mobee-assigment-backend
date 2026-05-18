import { Head, Link, router } from '@inertiajs/react';
import { Edit, Plus, Trash2 } from 'lucide-react';
import { useState } from 'react';
import { create, destroy, edit } from '@/routes/admin/cars';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

type Car = {
    id: number;
    brand: string;
    model: string;
    type: string;
    image_url: string;
    likes_count: number;
};

export default function AdminCarsIndex({ cars }: { cars: Car[] }) {
    const [search, setSearch] = useState('');
    const [deletingCar, setDeletingCar] = useState<Car | null>(null);

    const filtered = cars.filter(
        (c) =>
            c.brand.toLowerCase().includes(search.toLowerCase()) ||
            c.model.toLowerCase().includes(search.toLowerCase()) ||
            c.type.toLowerCase().includes(search.toLowerCase()),
    );

    function handleDelete(car: Car) {
        router.delete(destroy({ car: car.id }).url, {
            preserveScroll: true,
            onFinish: () => setDeletingCar(null),
        });
    }

    return (
        <>
            <Head title="Car Inventory" />

            <div className="flex flex-col gap-6 p-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold tracking-tight">Car Inventory</h1>
                        <p className="text-muted-foreground">{cars.length} cars in inventory</p>
                    </div>
                    <Button asChild>
                        <Link href={create()}>
                            <Plus className="mr-2 size-4" />
                            Add Car
                        </Link>
                    </Button>
                </div>

                <Card>
                    <CardHeader className="pb-3">
                        <div className="flex items-center justify-between">
                            <CardTitle>All Cars</CardTitle>
                            <Input
                                placeholder="Search brand, model or type…"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                className="w-64"
                            />
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="w-16">Image</TableHead>
                                    <TableHead>Brand</TableHead>
                                    <TableHead>Model</TableHead>
                                    <TableHead>Type</TableHead>
                                    <TableHead className="text-right">Likes</TableHead>
                                    <TableHead className="w-24 text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {filtered.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center text-muted-foreground">
                                            No cars found.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    filtered.map((car) => (
                                        <TableRow key={car.id}>
                                            <TableCell>
                                                <img
                                                    src={car.image_url}
                                                    alt={`${car.brand} ${car.model}`}
                                                    className="h-10 w-16 rounded object-cover"
                                                />
                                            </TableCell>
                                            <TableCell className="font-medium">{car.brand}</TableCell>
                                            <TableCell>{car.model}</TableCell>
                                            <TableCell>
                                                <Badge variant="secondary">{car.type}</Badge>
                                            </TableCell>
                                            <TableCell className="text-right">{car.likes_count}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-1">
                                                    <Button variant="ghost" size="icon" asChild>
                                                        <Link href={edit({ car: car.id })}>
                                                            <Edit className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="ghost"
                                                        size="icon"
                                                        className="text-destructive hover:text-destructive"
                                                        onClick={() => setDeletingCar(car)}
                                                    >
                                                        <Trash2 className="size-4" />
                                                    </Button>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>

            {/* Delete confirmation dialog */}
            <Dialog open={!!deletingCar} onOpenChange={(open) => !open && setDeletingCar(null)}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Remove car?</DialogTitle>
                        <DialogDescription>
                            This will permanently remove{' '}
                            <span className="font-semibold">
                                {deletingCar?.brand} {deletingCar?.model}
                            </span>{' '}
                            from the inventory and delete all associated likes.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setDeletingCar(null)}>
                            Cancel
                        </Button>
                        <Button
                            variant="destructive"
                            onClick={() => deletingCar && handleDelete(deletingCar)}
                        >
                            Remove
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
}
