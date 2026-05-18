import { Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { index } from '@/routes/admin/users';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { User } from '@/types';

type Car = {
    id: number;
    brand: string;
    model: string;
    type: string;
    image_url: string;
};

export default function AdminUserShow({
    user,
    liked_cars,
}: {
    user: User;
    liked_cars: Car[];
}) {
    return (
        <>
            <Head title={`User — ${user.name}`} />

            <div className="flex flex-col gap-6 p-6">
                <div className="flex items-center gap-4">
                    <Button variant="outline" size="sm" asChild>
                        <Link href={index()}>
                            <ArrowLeft className="mr-1 size-4" />
                            Back to Users
                        </Link>
                    </Button>
                </div>

                {/* User info */}
                <Card>
                    <CardHeader>
                        <CardTitle>User Details</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-2 text-sm">
                        <div className="flex gap-2">
                            <span className="w-28 text-muted-foreground">Name</span>
                            <span className="font-medium">{user.name}</span>
                        </div>
                        <div className="flex gap-2">
                            <span className="w-28 text-muted-foreground">Email</span>
                            <span>{user.email}</span>
                        </div>
                        <div className="flex gap-2">
                            <span className="w-28 text-muted-foreground">Joined</span>
                            <span>{new Date(user.created_at).toLocaleDateString()}</span>
                        </div>
                        <div className="flex gap-2">
                            <span className="w-28 text-muted-foreground">Verified</span>
                            <span>
                                {user.email_verified_at ? (
                                    <Badge variant="secondary">Verified</Badge>
                                ) : (
                                    <Badge variant="outline">Unverified</Badge>
                                )}
                            </span>
                        </div>
                    </CardContent>
                </Card>

                {/* Liked cars */}
                <Card>
                    <CardHeader>
                        <CardTitle>Liked Cars ({liked_cars.length})</CardTitle>
                    </CardHeader>
                    <CardContent>
                        {liked_cars.length === 0 ? (
                            <p className="text-sm text-muted-foreground">This user has not liked any cars yet.</p>
                        ) : (
                            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {liked_cars.map((car) => (
                                    <div
                                        key={car.id}
                                        className="overflow-hidden rounded-lg border border-border"
                                    >
                                        <img
                                            src={car.image_url}
                                            alt={`${car.brand} ${car.model}`}
                                            className="h-36 w-full object-cover"
                                        />
                                        <div className="p-3">
                                            <p className="font-semibold">{car.brand} {car.model}</p>
                                            <Badge variant="secondary" className="mt-1 text-xs">{car.type}</Badge>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
